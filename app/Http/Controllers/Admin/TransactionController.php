<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ClientMessageEnum;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Enums\ShippingMethods;
use App\Enums\UserTypes;
use App\Events\Transaction as TransactionEvents;
use App\Exports\OrdersCanceledExport;
use App\Exports\SubOrdersExport;
use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Integrations\Shipping\Shipment;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductWarehouseStock;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\ShippingType;
use App\Models\Transaction;
use App\Models\Warehouse;
use App\Pipelines\Admin\Transaction\FilterCode;
use App\Pipelines\Admin\Transaction\FilterCustomer;
use App\Pipelines\Admin\Transaction\FilterDate;
use App\Pipelines\Admin\Transaction\FilterShippingMethod;
use App\Pipelines\Admin\Transaction\FilterShippingType;
use App\Pipelines\Admin\Transaction\FilterStatus;
use App\Pipelines\Admin\Transaction\FilterTracking;
use App\Repositories\Api\TransactionRepository;
use App\Services\Admin\TransactionService;
use App\Services\ClientMessageService;
use Error;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use App\Integrations\Shipping\Integrations\Aramex\Aramex;
use App\Models\OrderShipFail;
use App\Models\OrderVendorShipping;
use App\Models\OrderVendorShippingWarehouse;
use Illuminate\Support\Facades\Http;
use App\Models\OrderCancelType;
use App\Jobs\SendSmsJob;
use App\Repositories\Api\OrderRepository;

class TransactionController extends Controller
{
    public $service;
    public $repository;
    protected $aramex;
    protected $orderRepo;

    public function __construct(TransactionService $service, TransactionRepository $repository, OrderRepository $orderRepo, Aramex $aramex)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->orderRepo = $orderRepo;
    }

    /**
     * List all Carts.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = Transaction::where('type','order')->with('orderVendorShippings')->where('status','!=',OrderStatus::WAITINGPAY);
        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                FilterStatus::class,
                FilterCustomer::class,
                FilterCode::class,
                FilterDate::class,
                FilterTracking::class,
                FilterShippingMethod::class,
                FilterShippingType::class,
            ])
            ->thenReturn();
        $transactions = $query->descOrder()->paginate($request->per_page ?? 100)->withQueryString();

        $shipping_types = ShippingType::all();
        $shipping_methods = ShippingMethod::all();
        $statuses = OrderStatus::getUnifiedStatusList();
        return view('admin.transaction.index', ['transactions' => $transactions, 'statuses' => $statuses, 'shipping_types' => $shipping_types, 'shipping_methods' => $shipping_methods]);
    }

    /**
     * List all Carts.
     *
     * @return JsonResponse
     */
    public function canceled_orders(Request $request)
    {
        $query = Order::where('status', 'canceled')->with('orderVendorShippings');
        if (request()->get('shipping_method') != null && request()->get('shipping_method') != '') {
            $query = $query->where('delivery_type', request()->get('shipping_method'));
        }
        if (request()->get('code') != null && request()->get('code') != '') {
            $query = $query->where('code', request()->get('code'));
        }
        if (request()->get('customer') != null && request()->get('customer') != '') {
            $query = $query->where('customer_name', 'like', '%' . request()->get('customer') . '%');
        }
        if (request()->get('dues') != null && request()->get('dues') == 'pending')
        {
            $query = $query->whereIn('refund_status', ['pending','no_found']);
        }
        elseif (request()->get('dues') != null && request()->get('dues') != '') {
            $query = $query->where('refund_status', request()->get('dues'));
        }
        $transactions = $query->descOrder()->paginate(10);
        $shipping_methods = ShippingMethod::all();
        return view('admin.transaction.canceled_orders', ['transactions' => $transactions, 'shipping_methods' => $shipping_methods]);
    }

    /**
     * List all Carts.
     *
     * @return JsonResponse
     */
    public function sub_orders(Request $request)
    {

        $query = Order::whereHas('transaction')->with(['orderVendorShippings','orderNote'])->where('status','!=',OrderStatus::WAITINGPAY);
        if (request()->get('shipping_method') == 'none') {
            $query = $query->where('delivery_type',NULL);
        } elseif (request()->get('shipping_method') != null && request()->get('shipping_method') != '') {
            $query = $query->where('delivery_type', request()->get('shipping_method'));
        }

        if (request()->get('code') != null && request()->get('code') != '') {
            $query = $query->where(function($qr){
                $qr->where('code', request()->get('code'))->orWhereHas('transaction', function($qrTransaction){
                    $qrTransaction->where('code', request()->get('code'));
                });
            });
        }
        if (request()->get('customer') != null && request()->get('customer') != '') {
            $query = $query->where('customer_name', 'like', '%' . request()->get('customer') . '%');
        }
        if (request()->get('dues') != null && request()->get('dues') != '') {
            $query = $query->where('refund_status', request()->get('dues'));
        }
        if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
        {
            $query =   $query->whereDate('orders.created_at','>=' ,request('from'))->whereDate('orders.created_at','<=' ,request('to'));
        }
        if (request()->get('status') != null && request()->get('status') != '') {
            $query = $query->whereIn('status', request()->get('status'));
        }
        if (request()->has('shipping_type') && request('shipping_type') != '')
        {
            $search = request('shipping_type');
            $query->whereHas('orderVendorShippings', function($q) use($search){
                $q->where('shipping_type_id' , $search);
            });
        }

        if (request()->has('gateway_tracking_id') && request('gateway_tracking_id') != '')
        {
            $search_track = request('gateway_tracking_id');
            $query->whereHas('orderShip', function($q) use($search_track){
                $q->where('gateway_tracking_id' , $search_track);
            });
        }
        $main_transactions = $query->descOrder()->paginate(10);
        $shipping_methods = ShippingMethod::all();
        $statuses = OrderStatus::getUnifiedStatusList();
        $shipping_types = ShippingType::all();
        return view('admin.transaction.sub_orders', ['main_transactions' => $main_transactions,'statuses' => $statuses,'shipping_types' => $shipping_types,'shipping_methods' => $shipping_methods]);
    }

    /**
     * @param int $transactionId
     * @return View
     */
    public function show(int $transactionId): View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId)
            ->load([
                "orderVendorShippings",
                "orders.orderProducts.product", "customer", "warnings", "onlinePayment",
                // "addresses" => fn($a) => $a->withTrashed()->with('country'),
                "orderShip" => fn($o) => $o->with([
                    'transaction' => fn($t) => $t->with(['shippingMethod', 'warehouseShippingRequest'])
                ])
            ]);
        return view('admin.transaction.show', [
            'transaction' => $transaction,
            'breadcrumbParent' => 'admin.transactions.index',
            'breadcrumbParentUrl' => route('admin.transactions.index')
        ]);
    }

    public function manage(int $transactionId)
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $refundStatuses = ['no_found' => 'لا يوجد', 'pending' => 'معلق', 'completed' => 'تم ارجاع جميع المستحقات'];

        return view('admin.transaction.manage', [
            'transaction' => $transaction,
            'breadcrumbParent' => 'admin.transactions.index',
            'breadcrumbParentUrl' => route('admin.transactions.index'),
            'statuses' => OrderStatus::getUnifiedStatusList(),
            'refundStatuses' => $refundStatuses
        ]);
    }

    public function update(Transaction $transaction)
    {
        if (!OrderStatus::isStatusHasHigherOrder($transaction->status, request()->get('status') ?? '' !== null)) {
            return redirect()->back()->with("error", __('admin.transaction_status_not_high'));
        }
        if (
            (request()->get('status') == OrderStatus::IN_DELEVERY || request()->get('status') == OrderStatus::SHIPPING_DONE) &&
            (!$transaction->orderShip || !$transaction->orderShip->gateway_tracking_id)
        ) return redirect()->back()->with("error", __('admin.transaction_not_has_ship'));
        // TODO: refactor (update orders status after update transaction status)
        // $transaction = $this->service->update($transaction);
        if (request()->get('status') != $transaction->status) {
            $transaction->update([
                'status' => request()->get('status'),
                'note' => request()->get('note'),
            ]);
            switch (request()->get('status')) {
                case OrderStatus::IN_DELEVERY:
                    event(new TransactionEvents\OnDelivery($transaction));
                    break;
                case OrderStatus::SHIPPING_DONE:
                    event(new TransactionEvents\Delivered($transaction->load("orders.vendor.wallet.transactions")));
                    break;
                case OrderStatus::COMPLETED:
                    event(
                        new TransactionEvents\Completed($transaction->load("orders.vendor.wallet.transactions"))
                    );
                    break;
            }
        } else {
            $transaction->update(['note' => request()->get('note')]);
        }

        return redirect()->route('admin.transactions.manage', ['transaction' => $transaction]);
    }


    public function refund_status_completed(Order $order)
    {
        if ($order->id) {
            $order->refund_status =  'completed';
            $order->saveQuietly();
            return back()->with('success', __('admin.transaction_refund_status_completed'));
        }
        return redirect()->back();
    }

    public function sendToBezz(Transaction $transaction)
    {
        if (!$transaction->orderShip) {
            try {
                Shipment::make(ShippingMethods::BEZZ)->createShipment($transaction);
            } catch (Exception|Error $e) {
                $transaction->warnings()->create([
                    'message' => $e->getMessage(),
                    'reference_type' => 'BeezShipment',
                ]);
                return back()->with('error', $e->getMessage());
            }
            return back()->with('success', __('admin.transaction_sent_to_bezz'));
        }
        return back()->with('error', __('admin.transaction_sent_to_bezz_before'));
    }


    public function getOrderStatus(Order $order)
    {
        $refundStatuses = ['no_found' => 'لا يوجد', 'pending' => 'معلق', 'completed' => 'تم ارجاع جميع المستحقات'];
        return view('admin.transaction.manage-order', [
            'order' => $order,
            'statuses' => OrderStatus::getUnifiedStatusList(),
            'refundStatuses' => $refundStatuses
        ]);
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'no_packages' => 'required_if:status,==,processing|numeric|min:1|max:1000',
            'status' => 'nullable|in:registered,in_shipping,processing,completed',
            'note' => 'nullable',
            'refund_status' => 'nullable|in:pending,completed'
        ]);

        if (isset($data['note']) && $order->note != $data['note']) {
            $order->update(['note' => $data['note']]);
        } elseif ($data['status'] == 'processing') {
            $order->update(['no_packages' => $data['no_packages']]);
        } elseif (!isset($data['status']) && !isset($data['refund_status']) && (isset($data['note']) && $order->note == $data['note'])) {
            Alert::error(
                'خطا',
                'لا يمكن تعديل الحاله بنفس الحاله'
            );
            return redirect()->back();
        }

        // ORDER VENDOR SHIPPING INFO
        $orderVendorShipping = $order->orderShipping;
        // RECEIVE CASE
        if (($orderVendorShipping->shipping_type_id == 1)) {
            $status = $data['status'];
            $orderVendorShipping->update(['status' => $status]);
            $order->status = $status;
            $order->save();

            $userPortal = $order->transaction->client;
            if ($status === 'processing') {
                $orderWarehouses = $order->orderVendorShippingWarehouses()->where('shipping_type_id', $orderVendorShipping->shipping_type_id)->get();
                foreach ($orderWarehouses as $warehouse) {
                    $code = rand(1111, 9999);
                    $warehouse->update(['receive_order_code' => $code]);
                    ClientMessageService::receiveTransaction(ClientMessageEnum::ReceiveTransaction, $warehouse, $code, $userPortal, $orderVendorShipping->order->code, $orderVendorShipping->order->no_packages);
                }
            } elseif ($orderVendorShipping->status == 'completed') {
                         // update order delivery time when order comes and the order has no refund
                if($order->status == OrderStatus::COMPLETED && $orderVendorShipping->status == OrderStatus::COMPLETED){
                        $order->update(['delivered_at' => now()]);
               }
                ClientMessageService::completedTransaction(ClientMessageEnum::CompletedTransaction, $userPortal, $orderVendorShipping->order->code, $orderVendorShipping->transaction->id);
            }
            Alert::success(__('translation.order_updated_successfully'));
            return back();

        } else {
            // ARAMEX CODE
            if ($orderVendorShipping->shipping_method_id == 1) {
                if (isset($data['status']) && $data['status'] == 'processing') {
                    $response = Shipment::make(ShippingMethods::ARAMEX)->createShipment($orderVendorShipping->order, $orderVendorShipping, ShippingMethods::ARAMEX);
                    if (isset($response['status']) && !$response['status']) {
                        Alert::error($response['message']);
                        return back();
                    }
                    $orderVendorShipping->update(['is_accepted_shipping' => 1, 'status' => 'processing']);
                    $orderVendorShipping->order->update(['status' => 'processing']);
                    $userPortal = $orderVendorShipping->order->transaction->client;
                    ClientMessageService::OnDeliveryTransaction(ClientMessageEnum::OnDeliveryTransaction, $userPortal, $orderVendorShipping->order->code);
                }

                if (isset($data['status']) && $data['status'] == 'completed') {
                    $order->update(['delivered_at' => now()]);
                    $userPortal = $orderVendorShipping->order->transaction->client;
                    ClientMessageService::completedTransaction(ClientMessageEnum::CompletedTransaction, $userPortal, $orderVendorShipping->order->code, $order->transaction);
                }


            } elseif ($orderVendorShipping->shipping_method_id == 2) {
                // SPL CODE
                if (isset($data['status']) && $data['status'] == 'processing') {
                    $response = Shipment::make(ShippingMethods::SPL)->createShipment($orderVendorShipping->order, $orderVendorShipping, ShippingMethods::SPL);
                    if (isset($response['status']) && !$response['status']) {
                        Alert::error($response['message']);
                        return back();
                    }
                    $orderVendorShipping->update(['is_accepted_shipping' => 1, 'status' => 'processing']);
                    $orderVendorShipping->order->update(['status' => 'processing']);
                    $userPortal = $orderVendorShipping->order->transaction->client;
                    ClientMessageService::OnDeliveryTransaction(ClientMessageEnum::OnDeliveryTransaction, $userPortal, $orderVendorShipping->order->code);
                }

                if (isset($data['status']) && $data['status'] == 'completed') {
                    $order->update(['delivered_at' => now()]);
                    $userPortal = $orderVendorShipping->order->transaction->client;
                    ClientMessageService::completedTransaction(ClientMessageEnum::CompletedTransaction, $userPortal, $orderVendorShipping->order->code, $order->transaction);
                }
            }
        }


        $order->update($data);
        if (isset($data['refund_status'])) {
            $order->withoutEvents(function () use ($order, $data) {
                $order->refund_status = $data['refund_status'];
                $order->save();
            });
        }



        Alert::success(__('translation.order_updated_successfully'));
        return redirect()->back();

    }


    /**
     * Return Invoice Page.
     */
    public function invoice(int $transactionId): View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key");
        $transaction = $transaction->load([
            "orders.orderProducts.product", "addresses" => fn($a) => $a->withTrashed()->with('country'),
        ]);
        return view('admin.transaction.invoice', [
            'transaction' => $transaction,
            'settings' => $settings,
            'breadcrumbParent' => 'admin.transactions.show',
            'breadcrumbParentUrl' => route('admin.transactions.show', $transactionId)
        ]);
    }

    /**
     * Return Invoice Page.
     */
    public function invoicePdf(int $transactionId): View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key")->toArray();
        $transaction = $transaction->load([
            "orders.orderProducts.product", "addresses" => fn($a) => $a->withTrashed()->with('country'),
        ]);

        $pdf = \PDF::loadView('admin.transaction.invoice_pdf', compact("settings", "transaction"), [], [
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        return $pdf->stream('order_invoice.pdf');
    }

    /**
     * Array of invoice header info.
     */
    private function _invoiceHeaderInfo(): array
    {
        return [
            "site_logo",
            "address",
            "zip_code",
            "legal_registration_no",
            "email",
            "website",
            "phone",
            "tax_no"
        ];
    }


    public function excel(Request $request)
    {
        // return $request;
        return Excel::download(new TransactionsExport($request), 'orders.xlsx');
    }

    public function canceled_export(Request $request)
    {
        return Excel::download(new OrdersCanceledExport($request), 'orders_canceled.xlsx');
    }
    public function sub_orders_export(Request $request)
    {
        return Excel::download(new SubOrdersExport($request), 'sub_orders.xlsx');
    }

    public function shippingFailedOrders(Request $request){
        $fails = OrderShipFail::active()->latest()->paginate(50);
        return view('admin.transaction.shipping_failed_orders', compact('fails'));
    }

    public function shippingFailedOrdersResend($id,Request $request){
        $OrderShipFail = OrderShipFail::findOrFail($id);
        $order = Order::findOrFail($OrderShipFail->order_id);
        $order_vendor_shipping = OrderVendorShipping::findOrFail($OrderShipFail->orderVendorShipping_id);

        //see ShippingMethods
        $shippingMethod = $OrderShipFail->shipping == 'aramex' ? 1 : 2;

        try {
            $response = Shipment::make($shippingMethod)->createShipment($order , $order_vendor_shipping , $shippingMethod);

            if((isset($response['status']) && !$response['status']) ){
                Alert::error( $response['message'] );
                return back();
            }

            OrderShipFail::where('order_id',$order->id)->update(['is_active'=>0]);

            Alert::success(__('translation.shipping_send_successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            $getFile = $e->getFile() ?? '';
            $getLine = $e->getLine() ?? '';
            $getMessage = $e->getMessage() ?? '';
            $errorMessage = 'An error occurred in ' . $getFile . ' on line ' . $getLine . ': ' . $getMessage;
            session()->flash('warning', $errorMessage);
            return back();
        }

    }

    public function resendReceiveCode($id){
        $code =  rand(1000,9999);
        $warehouse = OrderVendorShippingWarehouse::findOrFail($id);
        $warehouse->update(['receive_order_code' => $code]);
        $orderVendorShipping = $warehouse->orderVendorShipping;
        $userPortal = $orderVendorShipping->order->transaction->client;

        ClientMessageService::receiveTransaction(ClientMessageEnum::ReceiveTransaction , $warehouse ,$code, $userPortal , $orderVendorShipping->order->code , $orderVendorShipping->order->no_packages);
        session()->flash('success', 'تم الإرسال بنجاح');
        return back();
    }

    public function PrintLabel($tracking, Request $request)
    {
        $data = [
            "ClientInfo" =>[
                "UserName"=> config("shipping.aramex.UserName"),
                "Password"=> config("shipping.aramex.Password"),
                "Version"=> config("shipping.aramex.Version"),
                "AccountNumber"=> config("shipping.aramex.AccountNumber"),
                "AccountPin"=> config("shipping.aramex.AccountPin"),
                "AccountEntity"=> config("shipping.aramex.AccountEntity"),
                "AccountCountryCode"=> config("shipping.aramex.AccountCountryCode"),
                "Source"=> config("shipping.aramex.Source")
            ],
            "ShipmentNumber" => $tracking,
            "LabelInfo" => [
                "ReportID" => 9201,
                "ReportType" => "URL",
            ],
            "Transaction" => [
                "Reference1" => "",
                "Reference2" => "",
                "Reference3" => "",
                "Reference4" => "",
                "Reference5" => "",
            ],
        ];

        $url = "https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/PrintLabel";
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, $data);

        $res = $response->getBody()->getContents();
        if ($response->successful()) {
            if (isset(json_decode($response)->ShipmentLabel->LabelURL)) {
                return redirect()->to(json_decode($response)->ShipmentLabel->LabelURL);
            }
        }

        session()->flash('warning', $res);
        return redirect()->back();
    }

    public function changeWarehouse($order_vendor_warehouse_id, Request $request)
    {
        $request->validate([
            'warehouse_id' => ['required', 'exists:warehouses,id']
        ]);

        $order_vendor_warehouse = OrderVendorShippingWarehouse::findOrFail($order_vendor_warehouse_id);

        $old_warehouse = Warehouse::findOrFail($order_vendor_warehouse->warehouse_id);
        $warehouse = Warehouse::findOrFail($request->warehouse_id);

        $stock = ProductWarehouseStock::where('product_id', $order_vendor_warehouse->product_id)
            ->where('warehouse_id', $warehouse->id)->firstOrFail();

        $old_stock = ProductWarehouseStock::where('product_id', $order_vendor_warehouse->product_id)
        ->where('warehouse_id', $old_warehouse->id)->firstOrFail();



        $order_product = OrderProduct::where('order_id', $order_vendor_warehouse->order_id)
        ->where('product_id',$order_vendor_warehouse->product_id)->firstOrFail();

        if($stock->stock < $order_product->quantity){
            return redirect()->back()
                ->with(['failed' => __("translation.change_city.no_enough_quantity")]);
        }

        if($order_vendor_warehouse->vendor_id != $warehouse->vendor_id){
            return redirect()->back()
                ->with(['failed' =>  __("translation.change_city.vendor_not_correct")]);
        }

        try{
            DB::beginTransaction();
            $stock->update(['stock' => $stock->stock - $order_product->quantity]);
            $old_stock->update(['stock' => $old_stock->stock + $order_product->quantity]);

            $order_vendor_warehouse->warehouse_id = $warehouse->id;
            $order_vendor_warehouse->save();
            DB::commit();
        }catch(\Exception $ex){
            DB::rollback();
            throw $ex;
        }

        return redirect()->back()
            ->with(['success' => trans('translation.change_city.successfully')]);
    }

    #إلغاء الفرعي
    public function cancelOrder($id, Request $request){
        $request->validate([
            'withShipping' => 'required|in:yes,no'
        ]);

        #find order by id
        $order = Order::whereNotIn('status',[OrderStatus::COMPLETED,OrderStatus::CANCELED,OrderStatus::REFUND])->findOrFail($id);

        #store withShipping or withoutShipping
        OrderCancelType::create([
            'order_id' => $order->id,
            "type" =>  ($request->withShipping == 'yes') ? 'withShipping' : 'withoutShipping'
        ]);

        #cancel repository
        $isCanceled = $this->orderRepo->cancel($order);
        if($isCanceled['success'] == false){
            return redirect()->back()->with('error',$isCanceled['message']);
        }

        #change transaction status
        if(!$order->transaction->orders()->where('status','!=',OrderStatus::CANCELED)->exists()){
            $order->transaction->update(['status' => OrderStatus::CANCELED]);
            event(new TransactionEvents\Cancelled($order->transaction));
        }

        if(!session()->has('warning')) session()->flash('success', __('translation.canceled'));
        return redirect()->back();
    }


    // Refund Order
    public function refundOrder($id, Request $request){
        $request->validate([
            'withShipping' => 'required|in:yes,no',
            'refund_reason' => 'required'
        ]);

        #find order
        $order = Order::where('status', OrderStatus::COMPLETED)->where('delivered_at', '>', now()->subDays(3))->findOrFail($id);

        #store withShipping or withoutShipping
        OrderCancelType::create([
            'order_id' => $order->id,
            'type' => ($request->withShipping == 'yes') ? 'withShipping' : 'withoutShipping'
        ]);

        #refund repository
        $isRefunded = $this->orderRepo->refund($order);
        if($isRefunded['success'] == false){
            return redirect()->back()->with('error',$isRefunded['message']);
        }

        #change transaction status
        if (!$order->transaction->orders()->where('status', '!=', OrderStatus::REFUND)->exists()) {
            $order->transaction->update(['status' => OrderStatus::REFUND]);
            event(new TransactionEvents\Refund($order->transaction));
        } elseif (!$order->transaction->orders()->whereNotIn('status', [OrderStatus::COMPLETED, OrderStatus::REFUND])->exists()) {
            $order->transaction->update(['status' => OrderStatus::COMPLETED]);
        }


        if(!session()->has('warning')) session()->flash('success', __('translation.refund'));
        return redirect()->back();
    }


}
