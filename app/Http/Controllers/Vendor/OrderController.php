<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use App\Models\ShippingType;
use Illuminate\Http\Request;
use App\Enums\PaymentMethods;
use App\Models\OrderStatusLog;
use App\Models\ShippingMethod;
use App\Services\OrderService;
use App\Enums\ClientMessageEnum;
use App\DataTables\OrderDataTable;
use App\Exports\VendorOrdersExport;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Services\ClientMessageService;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\OrderVendorShippingWarehouse;
use App\Repositories\Vendor\OrderRepository;
use App\Services\Invoices\NationalTaxInvoice;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class OrderController extends Controller
{
    public string $view;
    public function __construct(public OrderService $orderService)
    {
        $this->view = 'vendor/orders';
    }

    public function index(Request $request , OrderRepository $orderRepository) //OrderDataTable $dataTable
    {
       // customer=&date_from=&date_to=&status=&shipping_type=&shipping_method=&code=&track_id=1

       $orders = Order::where('vendor_id' , auth()->user()->vendor->id)->where('status','!=',OrderStatus::WAITINGPAY)
       ->when($request->has('customer') && $request->filled('customer') && $request->get('customer') != 'all' ,
        fn($query) =>
           $query->where("customer_name" , "like",'%'.$request->get('customer').'%')

       )->when($request->has('track_id') && $request->filled('track_id') , fn($query) =>
           $query->whereHas('orderShip' , function($subquery) use ($request){
               $subquery->whereGatewayTrackingId($request->track_id);
           })
       )->when($request->has('code') && $request->filled('code')  , fn($query) =>
           $query->whereCode($request->get('code'))

       )->when($request->has('date_from') && $request->filled('date_from') && $request->has('date_to') && $request->filled('date_to') ,
           fn($query) => $query->whereDate('created_at', ">=" ,$request->get('date_from'))->whereDate('created_at' , "<=" ,  $request->get('date_to'))

       )->when($request->has('status') && $request->filled('status') && $request->get('status') != 'all', fn($query)=>
           $query->whereStatus($request->get('status'))
       )->when($request->has('shipping_type') && $request->filled('shipping_type') , fn($query) =>
               $query->whereHas('orderVendorShippings' , fn($subquery) =>
               $subquery->whereShippingTypeId($request->get('shipping_type'))
           )
       )->when($request->has('shipping_method') && $request->filled('shipping_method') , fn($query) =>
           $query->whereHas('orderVendorShippings', fn($subquery) =>
               $subquery->whereShippingMethodId($request->get('shipping_method'))
           )
       );

       // if (isset($request->status) && $request->status != 'all') {
       //     if($request->status ==  OrderStatus::PAID){
       //         $orders = $orders->where(function($q){
       //             $q->where('status' , OrderStatus::REGISTERD)
       //                 ->orWhere('status' , OrderStatus::PAID);
       //         });
       //     }


       $orders = $orders->latest()->paginate(50);
       $statuses =OrderStatus::getUnifiedStatusList();
       $shipping_types = ShippingType::all();
       $shipping_methods = ShippingMethod::all();

        return view($this->view.'/index',compact('orders','request','statuses' , 'shipping_types' , 'shipping_methods'));

        //return $dataTable->render($this->view.'/index',compact('request','statuses' , 'shipping_types' , 'shipping_methods'));
    }

    public function show($id)
    {
        $order=$this->orderService->getOrderUsingID($id);
        $data['row'] = $order;
        $data['orderVendorShipping'] = $data['row']->orderVendorShippings()->where('vendor_id' , $data['row']->vendor_id)->first();
        if(auth()->user()->vendor_id != $data['row']->vendor_id){
            Alert::error( __('translation.error') , __('this order doesnt belong to you') );
            return back();

        }
        if($data['row']->transaction->onlinePayment)
        {
            $payment_data=$data['row']->transaction->onlinePayment;
            $payment_data->payment_method_translated = $payment_data->payment_method;//PaymentMethods::getStatus($payment_data->payment_method);
            $data['payment_data']=$payment_data;
        }

        if(!$order->hasBeenSeen()){
            OrderStatusLog::create([
                'order_id' => $order->id,
                'status' => "seen",
                'created_by' => auth()->check() ? auth()->user()->id : null,
            ]);
        }

        return view($this->view.'/show',$data);
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
    public function invoice(int $id) : View|RedirectResponse
    {
        $order = Order::with('orderProducts.product')->ownVendor()->findOrFail($id);
        return view($this->view .'.invoice', ['order' => $order]);
    }

    /**
     * Return Invoice Page.
     */
    public function invoicePdf(int $id)
    {
        $order = Order::ownVendor()->findOrFail($id);
        
        try {
            $invoiceGenerator = new NationalTaxInvoice;
            return $invoiceGenerator->getVendorPdf($order)->stream($invoiceGenerator->getFileName());
        }  catch (Exception $e) {
            return redirect()->back()->with("danger", ($e->getMessage() ?? ''));
        }
    }


    public function trackingAramex($trackID)
    {

        $data =  [
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
            "GetLastTrackingUpdateOnly"=> false,
            "Shipments"=> [
                $trackID
            ],
            "Transaction" => [
                "Reference1" => "",
                "Reference2" => "",
                "Reference3" => "",
                "Reference4" => "",
                "Reference5" => ""
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post(config('shipping.aramex.ARAMEXTRACKINGURL'), $data);

        if($response->successful())
        {
            return [
                'success'       => true,
                'WaybillNumber' => $response->json()['TrackingResults'][0]['Value'][0]['WaybillNumber'],
                'status'        => $response->json()['TrackingResults'][0]['Value'][0]['UpdateDescription'],
            ] ;
        }else{
            return [
                'success' => false,
                'message'  => "ERROR IN TRACKING !"
            ];
        }
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


        return redirect()->back()->withErrors('خطأ!');
    }

    public function saveNote($id, Request $request){
        $request->validate([
            'note' => 'required|string|min:3|max:2000'
        ]);

        $order = Order::where('vendor_id',auth()->user()->vendor_id)->findOrFail($id);
        $order->orderNote->updateOrCreate(
            ['order_id' => $order->id],
            ['note' => $request->note]
        );

        session()->flash('success', 'تم الحفظ بنجاح');
        return back();
    }

    public function resendReceiveCode($id){
        $code =  rand(1000,9999);
        $warehouse = OrderVendorShippingWarehouse::where('vendor_id',auth()->user()->vendor_id)->findOrFail($id);
        $warehouse->update(['receive_order_code' => $code]);
        $orderVendorShipping = $warehouse->orderVendorShipping;
        $userPortal = $orderVendorShipping->order->transaction->client;

        ClientMessageService::receiveTransaction(ClientMessageEnum::ReceiveTransaction , $warehouse ,$code, $userPortal , $orderVendorShipping->order->code , $orderVendorShipping->order->no_packages);
        session()->flash('success', 'تم الإرسال بنجاح');
        return back();
    }

    public function excel(Request $request){
        return Excel::download(new VendorOrdersExport($request), 'orders '.date('d-m-Y').'-'.Str::random(1).'.xlsx');
    }

    public function downloadInvoices(Request $request){
        $orders = Order::ownVendor()->delivered()->createdBetween()->latest()->limit(50)->get();
 
        return PDF::loadView('tax-invoices.vendor-all-invoices-pdf', [
            "orders" => $orders,
            "logo" => "images/logo.png",
            "transaction" => null,
        ])->stream(date('d-M').'-vendor-all-invoices.pdf');
    }
}
