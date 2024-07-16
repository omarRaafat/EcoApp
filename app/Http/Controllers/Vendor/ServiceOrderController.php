<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Order;
use App\Enums\ServiceOrderStatus;
use Illuminate\Support\Str;
use App\Models\ShippingType;
use Illuminate\Http\Request;
use App\Enums\PaymentMethods;
use App\Models\ServiceOrderStatusLog;
use App\Models\ShippingMethod;
use App\Enums\ClientMessageEnum;
use App\DataTables\OrderDataTable;
use App\Exports\VendorOrdersExport;
use App\Exports\VendorServiceOrdersExport;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\AssignServiceRequest;
use App\Models\AssignOrderServiceRequest;
use App\Models\OrderService;
use App\Models\OrderServiceStatusLog;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Services\ClientMessageService;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\OrderVendorShippingWarehouse;
use App\Models\Type;
use App\Models\TypeOfEmployee;
use App\Models\User;
use App\Repositories\Vendor\OrderRepository;
use App\Repositories\Vendor\ServiceOrderRepository;
use App\Services\Invoices\NationalTaxInvoice;
use App\Services\ServiceOrderService;
use Exception;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class ServiceOrderController extends Controller
{
    public string $view;
    public function __construct(public ServiceOrderService $orderService,public AssignOrderServiceRequest $assignOrderServiceRequest)
    {
        $this->view = 'vendor/service_orders';
    }

    public function index(Request $request, ServiceOrderRepository $orderRepository)
    {
        $authType = auth()->user()->type;
        if($authType == 'vendor'){
            $orders = OrderService::where('vendor_id',auth()->user()->vendor?->id)
                ->where('status', '!=', ServiceOrderStatus::WAITINGPAY)
                ->when($request->has('customer') && $request->filled('customer') && $request->get('customer') != 'all', fn($query) => $query->where('customer_name', 'like', '%' . $request->get('customer') . '%'))
                ->when($request->has('code') && $request->filled('code'), fn($query) => $query->whereCode($request->get('code')))
                ->when($request->has('date_from') && $request->filled('date_from') && $request->has('date_to') && $request->filled('date_to'), fn($query) => $query->whereDate('created_at', '>=', $request->get('date_from'))->whereDate('created_at', '<=', $request->get('date_to')))
                ->when($request->has('status') && $request->filled('status') && $request->get('status') != 'all', fn($query) => $query->whereStatus($request->get('status')));
        }else{
            $orders = OrderService::where('vendor_id',auth()->user()->vendor?->id)
            ->whereHas('assignServicesRequest',function($q){
                $q->where(function($query){
                    $query->where('created_by',auth()->user()->id);
                });
                $q->orwhere(function($query){
                    $query->where('assign_by',auth()->user()->id);
                });
            })
            ->where('status', '!=', ServiceOrderStatus::WAITINGPAY)
            ->when($request->has('customer') && $request->filled('customer') && $request->get('customer') != 'all', fn($query) => $query->where('customer_name', 'like', '%' . $request->get('customer') . '%'))
            ->when($request->has('code') && $request->filled('code'), fn($query) => $query->whereCode($request->get('code')))
            ->when($request->has('date_from') && $request->filled('date_from') && $request->has('date_to') && $request->filled('date_to'), fn($query) => $query->whereDate('created_at', '>=', $request->get('date_from'))->whereDate('created_at', '<=', $request->get('date_to')))
            ->when($request->has('status') && $request->filled('status') && $request->get('status') != 'all', fn($query) => $query->whereStatus($request->get('status')));
        }
        $orders = $orders->latest()->paginate(50);
        $statuses = ServiceOrderStatus::getUnifiedStatusList();

        return view($this->view . '/index', compact('orders', 'request', 'statuses'));
    }

    public function show($id)
    {
        // get type of user
        $authType = auth()->user()->type;
        // get type of employee
        $typeOfEmployeeId = auth()->user()->type_of_employee_id ?? null;
        $authLevel = TypeOfEmployee::where('id',$typeOfEmployeeId)->select('id','level')->first();
        if($authType == 'sub-vendor'){
            $vendorUsers = User::where('type','sub-vendor')->whereHas('typeOfEmployee', function($q) use($authLevel){
                $q->where('level','>=',$authLevel->level);
            })
            ->where('type_of_employee_id','!=',null)
            ->where('vendor_id',auth()->user()->vendor_id)
            ->where('id','!=',auth()->user()->id)
            ->get();
            $data['vendorUsers'] = $vendorUsers;
        }else{
            $vendorUsers = User::where('type','sub-vendor')
            ->where('type_of_employee_id','!=',null)
            ->where('vendor_id',auth()->user()->vendor_id)
            ->where('id','!=',auth()->user()->id)
            ->get();
            $data['vendorUsers'] = $vendorUsers;
        }
        $order = $this->orderService->getOrderUsingID($id);
        $data['row'] = $order;
        if (auth()->user()->vendor_id != $data['row']->vendor_id) {
            Alert::error(__('translation.error'), __('this order doesnt belong to you'));
            return back();
        }
        if ($data['row']->transaction->onlinePayment) {
            $payment_data = $data['row']->transaction->onlinePayment;
            $payment_data->payment_method_translated = $payment_data->payment_method; //PaymentMethods::getStatus($payment_data->payment_method);
            $data['payment_data'] = $payment_data;
        }

        if (!$order->hasBeenSeen()) {
            OrderServiceStatusLog::create([
                'order_service_id' => $order->id,
                'status' => 'seen',
                'created_by' => auth()->check() ? auth()->user()->id : null,
            ]);
        }

        return view($this->view . '/show', $data);
    }

    public function destroy($id)
    {
        //$this->orderService->delete($id);
        return true;
    }

    public function multiDelete(Request $request)
    {
        $this->orderService->multiDelete($request->ids);
        return true;
    }

    /**
     * Return Invoice Page.
     */
    public function invoice(int $id): View|RedirectResponse
    {
        $order = OrderService::with('orderServices.service')->ownVendor()->findOrFail($id);
        return view($this->view . '.invoice', ['order' => $order]);
    }

    /**
     * Return Invoice Page.
     */
    public function invoicePdf(int $id)
    {
        $order = OrderService::ownVendor()->findOrFail($id);

        try {
            $invoiceGenerator = new NationalTaxInvoice();
            return $invoiceGenerator->getServiceVendorPdf($order)->stream($invoiceGenerator->getFileName());
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('danger', $e->getMessage() ?? '');
        }
    }

    public function saveNote($id, Request $request)
    {
        $request->validate([
            'note' => 'required|string|min:3|max:2000',
        ]);

        $order = OrderService::where('vendor_id', auth()->user()->vendor_id)->findOrFail($id);
        $order->orderNote->updateOrCreate(['service_order_id' => $order->id], ['note' => $request->note]);

        session()->flash('success', 'تم الحفظ بنجاح');
        return back();
    }

    public function resendReceiveCode($id)
    {
        $code = rand(1000, 9999);
        $order = OrderService::findOrFail($id);
        $order->update(['receive_order_code' => $code]);
        $userPortal = $order->transaction->client;
        ClientMessageService::receiveServiceTransaction(ClientMessageEnum::ReceiveServiceTransaction , $code, $userPortal , $order->code);
        session()->flash('success', 'تم الإرسال بنجاح');
        return back();
    }

    public function excel(Request $request)
    {
        return Excel::download(new VendorServiceOrdersExport($request), 'orders ' . date('d-m-Y') . '-' . Str::random(1) . '.xlsx');
    }

    public function downloadInvoices(Request $request)
    {
        $orders = OrderService::ownVendor()->delivered()->createdBetween()->latest()->limit(50)->get();

        return PDF::loadView('service-tax-invoices.vendor-all-invoices-pdf', [
            'orders' => $orders,
            'logo' => 'images/logo.png',
            'transaction' => null,
        ])->stream(date('d-M') . '-vendor-all-invoices.pdf');
    }
    public function assignServiceRequest(AssignServiceRequest $request)
    {
        // if(AssignOrderServiceRequest::where('order_service_id',$request->order_service_id)->where('assign_by',$request->assign_by)->exists()){
        //     Alert::error(trans('translation.error'), __('vendors.assign-order-services.assign_error'));
        //     return redirect()->back();
        // }
        $assignServiceRequest = $this->assignOrderServiceRequest->create($request->validated());
        Alert::success('success message', __('vendors.assign-order-services.assign_success'));
        return redirect()->back();
    }
}
