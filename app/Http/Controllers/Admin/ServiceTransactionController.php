<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ClientMessageEnum;
use App\Enums\ServiceOrderStatus;
use App\Enums\PaymentMethods;
use App\Enums\ShippingMethods;
use App\Enums\UserTypes;
use App\Events\Transaction as TransactionEvents;
use App\Exports\OrdersCanceledExport;
use App\Exports\ServiceOrdersCanceledExport;
use App\Exports\ServiceSubOrdersExport;
use App\Exports\ServiceTransactionsExport;
use App\Exports\SubOrdersExport;
use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Integrations\Shipping\Shipment;
use App\Models\Order;
use App\Models\ServiceWarehouseStock;
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
use App\Models\OrderService;
use App\Repositories\Api\OrderRepository;
use App\Repositories\Api\ServiceOrderRepository;
use App\Services\Admin\ServiceTransactionService;

class ServiceTransactionController extends Controller
{
    public $service;
    public $repository;
    protected $orderRepo;

    public function __construct(ServiceTransactionService $service, TransactionRepository $repository, ServiceOrderRepository $orderRepo)
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
        $query = Transaction::where('type','order-service')->where('status','!=',ServiceOrderStatus::WAITINGPAY);
        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                FilterStatus::class,
                FilterCustomer::class,
                FilterCode::class,
                FilterDate::class,
            ])
            ->thenReturn();

        $transactions = $query->descOrder()->paginate($request->per_page ?? 100)->withQueryString();

        $statuses = ServiceOrderStatus::getUnifiedStatusList();
        return view('admin.service_transaction.index', ['transactions' => $transactions, 'statuses' => $statuses]);
    }

    /**
     * List all Carts.
     *
     * @return JsonResponse
     */
    public function canceled_orders(Request $request)
    {
        $query = OrderService::where('status', 'canceled');
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
        return view('admin.service_transaction.canceled_orders', ['transactions' => $transactions]);
    }

    /**
     * List all Carts.
     *
     * @return JsonResponse
     */
    public function sub_orders(Request $request)
    {
        $query = OrderService::whereHas('transaction')->with(['orderNote'])->where('status','!=',ServiceOrderStatus::WAITINGPAY);
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
            $query =   $query->whereDate('order_services.created_at','>=' ,request('from'))->whereDate('order_services.created_at','<=' ,request('to'));
        }
        if (request()->get('status') != null && request()->get('status') != '') {
            $query = $query->whereIn('status', request()->get('status'));
        }

        $main_transactions = $query->descOrder()->paginate(10);
        $statuses = ServiceOrderStatus::getUnifiedStatusList();
        return view('admin.service_transaction.sub_orders', ['main_transactions' => $main_transactions,'statuses' => $statuses]);
    }

    /**
     * @param int $transactionId
     * @return View
     */
    public function show(int $transactionId): View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId)
            ->load(["customer", "warnings", "onlinePayment"]);
        return view('admin.service_transaction.show', [
            'transaction' => $transaction,
            'breadcrumbParent' => 'admin.transactions.index',
            'breadcrumbParentUrl' => route('admin.transactions.index')
        ]);
    }

    public function manage(int $transactionId)
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $refundStatuses = ['no_found' => 'لا يوجد', 'pending' => 'معلق', 'completed' => 'تم ارجاع جميع المستحقات'];
        return view('admin.service_transaction.manage', [
            'transaction' => $transaction,
            'breadcrumbParent' => 'admin.transactions.index',
            'breadcrumbParentUrl' => route('admin.transactions.index'),
            'statuses' => ServiceOrderStatus::getUnifiedStatusList(),
            'refundStatuses' => $refundStatuses
        ]);
    }

    public function update(Transaction $transaction)
    {
        if (!ServiceOrderStatus::isStatusHasHigherOrder($transaction->status, request()->get('status') ?? '' !== null)) {
            return redirect()->back()->with("error", __('admin.transaction_status_not_high'));
        }
        if ((!$transaction->orderShip || !$transaction->orderShip->gateway_tracking_id)){
            return redirect()->back()->with("error", __('admin.transaction_not_has_ship'));
        }

        // TODO: refactor (update orders status after update transaction status)
        // $transaction = $this->service->update($transaction);
        if (request()->get('status') != $transaction->status) {
            $transaction->update([
                'status' => request()->get('status'),
                'note' => request()->get('note'),
            ]);
            switch (request()->get('status')) {
                case ServiceOrderStatus::COMPLETED:
                    event(
                        new TransactionEvents\Completed($transaction->load("order_services.vendor.wallet.transactions"))
                    );
                    break;
            }
        } else {
            $transaction->update(['note' => request()->get('note')]);
        }

        return redirect()->route('admin.transactions.manage', ['transaction' => $transaction]);
    }

    public function getOrderStatus(OrderService $order)
    {
        $refundStatuses = ['no_found' => 'لا يوجد', 'pending' => 'معلق', 'completed' => 'تم ارجاع جميع المستحقات'];
        return view('admin.service_transaction.manage-order', [
            'order' => $order,
            'statuses' => ServiceOrderStatus::getUnifiedStatusList(),
            'refundStatuses' => $refundStatuses
        ]);
    }

    public function updateOrderStatus(Request $request, OrderService $order)
    {
        $data = $request->validate([
            'status' => 'nullable|in:registered,processing,completed',
            'note' => 'nullable',
            'refund_status' => 'nullable|in:pending,completed'
        ]);

        if (isset($data['note']) && $order->note != $data['note']) {
            $order->update(['note' => $data['note']]);
        } elseif (!isset($data['status']) && !isset($data['refund_status']) && (isset($data['note']) && $order->note == $data['note'])) {
            Alert::error(
                'خطا',
                'لا يمكن تعديل الحاله بنفس الحاله'
            );
            return redirect()->back();
        }

        $userPortal = $order->transaction->client;

        if ($data['status'] === 'processing') {
            $code = rand(1111, 9999);
            $order->update(['receive_order_code' => $code]);
            ClientMessageService::receiveServiceTransaction(ClientMessageEnum::ReceiveServiceTransaction, $code, $userPortal, $order->code);
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

    public function invoice(int $transactionId): View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key");
        $transaction = $transaction->load([
            "orderServices.orderServices.service", "addresses" => fn($a) => $a->withTrashed()->with('country'),
        ]);

        return view('admin.service_transaction.invoice', [
            'transaction' => $transaction,
            'settings' => $settings,
            'breadcrumbParent' => 'admin.transactions.show',
            'breadcrumbParentUrl' => route('admin.service_transactions.show', $transactionId)
        ]);
    }

    public function invoicePdf(int $transactionId): View
    {
        $transaction = $this->service->getTransactionUsingID($transactionId);
        $settings = Setting::whereIn("key", $this->_invoiceHeaderInfo())->pluck("value", "key")->toArray();
        $transaction = $transaction->load([
            "order_services.orderServices.service", "addresses" => fn($a) => $a->withTrashed()->with('country'),
        ]);

        $pdf = \PDF::loadView('admin.transaction.invoice_pdf', compact("settings", "transaction"), [], [
            'format' => 'A4-P',
            'orientation' => 'P'
        ]);
        return $pdf->stream('order_invoice.pdf');
    }

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
        return Excel::download(new ServiceTransactionsExport($request), 'order_services.xlsx');
    }

    public function canceled_export(Request $request)
    {
        return Excel::download(new ServiceOrdersCanceledExport($request), 'orders_canceled.xlsx');
    }
    public function sub_orders_export(Request $request)
    {
        return Excel::download(new ServiceSubOrdersExport($request), 'sub_order_services.xlsx');
    }

    public function resendReceiveCode($id){
        $code =  rand(1000,9999);
        $order = OrderService::findOrFail($id);
        $order->update(['receive_order_code' => $code]);
        $userPortal = $order->transaction->client;
        ClientMessageService::receiveServiceTransaction(ClientMessageEnum::ReceiveServiceTransaction , $code, $userPortal , $order->code);
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

    #إلغاء الفرعي
    public function cancelOrder($id, Request $request){
        #find order by id
        $order = OrderService::whereNotIn('status',[ServiceOrderStatus::COMPLETED,ServiceOrderStatus::CANCELED])->findOrFail($id);

        #cancel repository
        $isCanceled = $this->orderRepo->cancel($order);
        if($isCanceled['success'] == false){
            return redirect()->back()->with('error',$isCanceled['message']);
        }

        #change transaction status
        if(!$order->transaction->orderServices()->where('status','!=',ServiceOrderStatus::CANCELED)->exists()){
            $order->transaction->update(['status' => ServiceOrderStatus::CANCELED]);
            event(new TransactionEvents\Cancelled($order->transaction));
        }

        if(!session()->has('warning')) session()->flash('success', __('translation.canceled'));
        return redirect()->back();
    }

}
