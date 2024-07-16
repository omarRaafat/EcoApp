<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\PaymentMethods;
use App\Exports\OrderShipping;
use App\Exports\ShippingCharges;
use App\Exports\MostSellingExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Exports\PaymentMethodExport;
use App\Exports\ShippingChargesWait;
use App\Http\Controllers\Controller;
use App\Services\Eportal\Connection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductQuantityExport;
use App\Exports\ShippingChargesCompleted;
use Illuminate\Database\Eloquent\Builder;
use App\Exports\Reports\VendorsSalesExport;
use App\Exports\Reports\SalesAllVendorsExport;
use App\Exports\Reports\VendorsEarningsExport;
use App\Models\ShippingMethod;
use App\Models\VendorWalletTransaction;

class ReportController extends Controller
{
    public function products_quantity(Request $request)
    {


        $data = $request->all();

        $products = Product::select('id', 'name', 'barcode', 'stock', 'vendor_id')
            ->with(['vendor' => function ($query) {
                $query->select('id', 'name')->with(['warehouses' => function ($q) {
                    $q->select('id', 'vendor_id', 'name')->withCount(['warehouseProducts']);
                }]);
            }]);

        if (isset($data['id'])) {
            $products->where('id', $data['id']);
        }
        if (isset($data['stock'])) {
            $products->where('stock', $data['stock']);
        }
        if (isset($data['barcode'])) {
            $products->where('barcode', $data['barcode']);
        }

        if (isset($data['product_name'])) {
            $products->where('name->ar', 'like', "%$data[product_name]%")
                ->orWhere('name->en', 'like', "%$data[product_name]%");
        }

        if (isset($data['vendor_name'])) {
            $products->whereHas('vendor', function ($q) use ($data) {
                $q->where('name->ar', 'like', "%$data[vendor_name]%")
                    ->orWhere('name->en', 'like', "%$data[vendor_name]%");
            });
        }
        if (isset($data['export_excel']) && $data['export_excel'] == true) {
            return Excel::download(new ProductQuantityExport($products), 'product_quantity.xlsx');
        }





        $products = $products->paginate();



        return view('admin.new-reports.products_quantity', compact('products'));
    }

    public function mostSellingProducts(Request $request)
    {
        $data = request()->all();
        $totalSells = Product::sum('no_sells');
        // return $totalSells;
        $productsQuery = Product::with('category:id,name')
            ->with('orderProducts.order', 'orderProducts')
            ->when($request->name, function ($query) use ($data) {
                $query->where(function ($q) use ($data) {
                    $q->where('name->ar', 'like', "%$data[name]%")
                        ->orWhere('name->en', 'like', "%$data[name]%");
                });
            })->when($request->created_from && $request->created_to, function ($query) use ($data) {
                $query->whereBetween('created_at', [$data['created_from'], $data['created_to']]);
            })
            ->where('no_sells', '>', 1) // select if there are more than one sell
            ->select(['id', 'category_id', 'name', 'price', 'no_sells', 'no_receive_from_vendor',
                DB::raw('ROUND((`no_sells` /' . $totalSells . ') * 100, 3) as sellsPercentage'),
            ])->orderBy('no_sells', 'desc');



        if (isset($data['export_excel']) && $data['export_excel'])
            return Excel::download(new MostSellingExport($productsQuery), 'most_selling' . time() . '.xlsx');

        $products = $productsQuery->paginate();
        return view('admin.new-reports.products.mostSellingProducts', compact('products'));
    }

    public function PaymentMethods(Request $request)
    {
        $data = $request->all();
        $paymentMethods = PaymentMethods::getPayments();
        $visa_amount = Order::when(request()->has('from') && request()->has('to'), function ($query) {
            $query->whereBetween('orders.created_at', [request()->from, request()->to]);
        })->where('status', 'completed')->where('payment_id', 2);

        $tabby_amount = Order::when(request()->has('from') && request()->has('to'), function ($query) {
            $query->whereBetween('orders.created_at', [request()->from, request()->to]);
        })->where('status', 'completed')->where('payment_id', 4);

        $wallet_amount = Order::when(request()->has('from') && request()->has('to'), function ($query) {
            $query->whereBetween('orders.created_at', [request()->from, request()->to]);
        })->where('status', 'completed');

        $total_transaction = $visa_amount->sum('visa_amount') + $wallet_amount->sum('wallet_amount') + $tabby_amount->sum('visa_amount');
        $total_transaction_count = $visa_amount->count() + $wallet_amount->count() + $tabby_amount->count();
        $results[] = (object)['name' => 'فيزا', 'transaction_count' => $visa_amount->count(), 'total_value' => round($visa_amount->sum('visa_amount'), 2)];
        $results[] = (object)['name' => 'المحفظه', 'transaction_count' => $wallet_amount->count(), 'total_value' => round($wallet_amount->sum('wallet_amount'), 2)];
        $results[] = (object)['name' => 'تابي', 'transaction_count' => $tabby_amount->count(), 'total_value' => round($tabby_amount->sum('visa_amount'), 2)];
        $results[] = (object)['name' => 'المجموع', 'transaction_count' => $total_transaction_count, 'total_value' => round($total_transaction, 2)];

        if (isset($data['export_excel']) && $data['export_excel'] == true) {
            return Excel::download(new PaymentMethodExport($results), 'payment_methods.xlsx');
        }

        return view('admin.new-reports.PaymentMethods', compact('results'));
    }

    public function SatisfactionClientsWallet(Request $request)
    {
        $clientWallets = Connection::getClientWallets($request, config('app.eportal_url') . 'get-all-client-wallets')->json();
        $clientWallets = (object)$clientWallets;
        return view('admin.new-reports.SatisfactionClientsWallet', compact('clientWallets'));
    }

    public function OrdersShipping(Request $request)
    {
        $orders = Order::query()->where('delivery_fees', '>', 0)->orderBy('id', 'desc');
        if (request()->has('from') && !empty($request->from)) {
            $orders = $orders->whereDate('created_at', '>=', request()->get('from'));
        }
        if (request()->has('to') && !empty($request->to)) {
            $orders = $orders->whereDate('created_at', '<=', request()->get('to'));
        }

        if (isset($request->export) && $request->export) {
            return Excel::download(new OrderShipping($orders->get()), 'Order-shipping.xlsx');
        }

        $paginateOrders = $orders->paginate();
        return view('admin.new-reports.OrdersShipping', compact('paginateOrders'));
    }

    public function ShippingCharges(Request $request)
    {
        $data = $request->all();
        $orders = Order::query()->whereHas('orderShipping', function ($q) {
            $q->where('shipping_type_id', 2);
        })->orderBy('id', 'desc');

        if (request()->has('from')) {
            $orders = $orders->whereDate('created_at', '>=', request()->get('from'));
        }
        if (request()->has('to')) {
            $orders = $orders->whereDate('created_at', '<=', request()->get('to'));
        }

        if (isset($data['export_excel']) && $data['export_excel'] == true) {
            return Excel::download(new ShippingCharges($orders), 'shipping_charge.xlsx');
        }

        $orders = $orders->paginate(10);

        return view('admin.new-reports.ShippingCharges', compact('orders'));
    }

    public function ShippingChargesCompleted(Request $request)
    {
        $data = $request->all();
        $orders = Order::with(['orderShipping','orderShip','vendor'])->whereHas('orderShipping', function ($q) {
            $q->where('shipping_type_id', 2);
        })
       // ->whereIn('status',[OrderStatus::COMPLETED, OrderStatus::PICKEDUP, OrderStatus::IN_SHIPPING])
        ->whereHas('orderShip',function($qr){
            $qr->where('status','!=','pending')
            ->when(request()->get('gateway_tracking_id'),function($qr2){
                $qr2->where('gateway_tracking_id', request()->get('gateway_tracking_id'));
            });
        })
        ->latest();

        if (request()->filled('from')) {
            $orders->whereDate('pickup_at', '>=', request()->input('from'));
        }

        if (request()->filled('to')) {
            $orders->whereDate('pickup_at', '<=', request()->input('to'));
        }

        if (request()->filled('shipping_method')) {
            $shippingMethodId = request()->input('shipping_method');
            $shippingMethod = ShippingMethod::findOrFail($shippingMethodId);
            $orders->where('delivery_type', $shippingMethod->name);
        }



        if (isset($data['export_excel']) && $data['export_excel']) {
            return Excel::download(new ShippingChargesCompleted($orders), 'shipping_charge_completed.xlsx');
        }

        $orders = $orders->paginate(50)->appends(request()->query());
        $shipping_methods = ShippingMethod::all();
        return view('admin.new-reports.ShippingChargesCompleted', compact('orders','shipping_methods'));
    }

    public function ShippingChargesWait(Request $request)
    {
        $data = $request->all();
        $orders = Order::query()->whereHas('orderShipping', function ($q) {
            $q->where('shipping_type_id', 2);
        })->whereHas('orderShip', function ($q) {
            $q->whereNotNull('gateway_tracking_id');
        })
        ->whereNotIn('status', ['completed', 'canceled'])->orderBy('id', 'desc');
        if (request()->has('from')) {
            $orders = $orders->whereDate('created_at', '>=', request()->get('from'));
        }
        if (request()->has('to')) {
            $orders = $orders->whereDate('created_at', '<=', request()->get('to'));
        }

        if (isset($data['export_excel']) && $data['export_excel'] == true) {
            return Excel::download(new ShippingChargesWait($orders), 'shipping_charge_wait.xlsx');
        }

        $orders = $orders->paginate(10);
        return view('admin.new-reports.ShippingChargesWait', compact('orders'));
    }

    public function logisticsPartner(Request $request)
    {
        return view('admin.new-reports.logisticsPartner');
    }

    public function SalesAllVendors(Request $request)
    {
       $orders = $this->getVendorSalesQuery($request);
       $vendors = Vendor::get();
        $getOrders = $orders->get();
        $orders = $orders->paginate(10);


        if (isset($request->all_export_excel) && $request->all_export_excel) {
            return Excel::download(new SalesAllVendorsExport($getOrders), 'sales_vendors '.Date('d-m-Y').Str::random(1).'.xlsx');
        }

        return view('admin.new-reports.SalesAllVendors', compact('orders','vendors'));
    }


    public function SalesAllVendorsPrint(Request $request  , $order_id = null)
    {

        $orders = $this->getVendorSalesQuery($request);

        if (!empty($order_id)) {
            $orders = $orders->where('id', $order_id);
        }
            $getOrders = $orders->get();

        return view("admin.new-reports.print.salesAllvendorsPrint", compact('getOrders'));
    }

    public function getVendorSalesQuery($request){
        $orders_query = Order::query()->with('vendor.wallet')
        ->select('vendor_id' , 'id' , 'wallet_id', DB::raw('SUM(sub_total) as total_without_vat,
         SUM(vat) as total_vat,
         SUM(total) as total_with_vat,
         ROUND((SUM(company_profit) - (SUM(company_profit) / 1.15)),2) as value_of_company_profit_vat,
         ROUND(SUM(company_profit) / 1.15,2) as total_company_profit_without_vat,
         ROUND(SUM(company_profit),2) as total_company_profit,
         ROUND(SUM(vendor_amount),2) as total_balance
         '
         ))->whereStatus(OrderStatus::COMPLETED)->groupBy('vendor_id')
         ->when($request->get('from') && $request->get('to'),function($query){
            $query->whereHas('vendorWalletTransactions',function($qr2){
                $qr2->createdBetween()->completed();
            });
            })
          ->when($request->has('vendor') && $request->filled('vendor') ,
            fn($query) => $query->where('vendor_id', $request->get('vendor'))
          )
          ->orderBy('id' , 'DESC');

          return $orders_query;

    }



    public function vendors_earnings(Request $request)
    {
        $vendors_query = Vendor::query()->with('owner')
       ->whereHas('orders',function($qr){
            $qr->where('status',OrderStatus::COMPLETED);
       })
       ->whereHas('vendorWalletTransactions', function($qr) use($request){
            $qr->where('status', 'completed')->when($request->get('from') && $request->get('to'),
                fn($qr) => $qr->whereDate('vendor_wallet_transactions.created_at' , '>=' , $request->get('from'))->whereDate('vendor_wallet_transactions.created_at' , '<=',$request->get('to')));
        })
       ->withSum(['vendorWalletTransactions as vendorWalletTransactionIn' => function ($query) use($request) {
            $query->where('operation_type', 'in')->where('status', 'completed')
            ->when($request->get('from') && $request->get('to'),
                fn($qr) => $qr->whereDate('vendor_wallet_transactions.created_at' , '>=' , $request->get('from'))->whereDate('vendor_wallet_transactions.created_at' , '<=',$request->get('to'))
       );
        }], 'amount')
        ->withSum(['vendorWalletTransactions as vendorWalletTransactionOut' => function ($query) use($request) {
            $query->where('operation_type', 'out')->where('status', 'completed')
            ->when($request->get('from') && $request->get('to') ,
                fn($qr) => $qr->whereDate('vendor_wallet_transactions.created_at' , '>=' , $request->get('from'))->whereDate('vendor_wallet_transactions.created_at' , '<=',$request->get('to'))
            );
        }], 'amount')
        ->orderBy('id' , 'DESC');

        $getVendors = $vendors_query->get();
        $sum_earn = round($getVendors->sum('vendorWalletTransactionIn') - $getVendors->sum('vendorWalletTransactionOut'), 2);
        $vendor_counts = $getVendors->count();

        if($request->has('all_export_excel')){
            return Excel::download(new VendorsEarningsExport($getVendors,$sum_earn,$vendor_counts), 'vendors_earnings.xlsx');
        }

        $vendors = $vendors_query->paginate(10);

        return view('admin.new-reports.vendors_earnings', compact('vendors'));
    }

    public function vendors_sales(Request $request)
    {
        $vendors = Vendor::select('name', 'id')->get()->map(fn($e) => ['id' => $e->id, 'name' => $e->getTranslation("name", "ar")]);

        $orders =  VendorWalletTransaction::with(['order','wallet.vendor'])->completed()->filterVendor()->createdBetween()->latest();

        if ($request->get('all_export_excel')) {
            return Excel::download(new VendorsSalesExport($orders->get()), 'vendors_sales.xlsx');
        }

        $collection = $orders->paginate(50);

        return view("admin.new-reports.vendors-orders", ['vendors' => $vendors, 'collection' => $collection]);
    }


    /**
     * @param  $order_id
     * @return View
     */
      /**
     * @param  $order_id
     * @return View
     */
    public function vendors_sales_print(Request $request)
    {
        $rows =  VendorWalletTransaction::with(['order','wallet.vendor'])->completed()->filterVendor()->createdBetween()->latest();

        $orders = $rows->get();
        $sub_total_in_sar_rounded = $orders->sum(function ($operation) {
            return $operation->order?->sub_total_in_sar_rounded  * 100;
        });
        $vat_in_sar_rounded = $orders->sum(function ($operation) {
            return $operation->order?->vat_in_sar_rounded  * 100;
        });
        $total_in_sar_rounded = $orders->sum(function ($operation) {
            return $operation->order?->total_in_sar_rounded  * 100;
        });
        $company_profit_without_vat_in_sar_rounded = $orders->sum(function ($operation) {
            return $operation->order?->company_profit_without_vat_in_sar_rounded  * 100;
        });
        $company_profit_vat_rate_rounded = $orders->sum(function ($operation) {
            return $operation->order?->company_profit_vat_rate_rounded  * 100;
        });
        $company_profit_in_sar_rounded = $orders->sum(function ($operation) {
            return $operation->order?->company_profit_in_sar_rounded  * 100;
        });

        $vendor_amount_in_sar_rounded = $orders->where('operation_type','in')->sum('amount');
        $vendor_out_in_sar_rounded = $orders->where('operation_type','out')->sum('amount');

        $collection = $rows->paginate(50);

        return view("admin.new-reports.print.vendors_sales_print", compact('collection','sub_total_in_sar_rounded','vat_in_sar_rounded','total_in_sar_rounded',
            'company_profit_without_vat_in_sar_rounded','company_profit_vat_rate_rounded','company_profit_in_sar_rounded','vendor_amount_in_sar_rounded','vendor_out_in_sar_rounded'));
    }

}
