<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ClientMessageEnum;
use App\Enums\OrderStatus;
use App\Enums\ShippingMethods;
use App\Integrations\Shipping\Shipment;
use App\Models\ClientMessage;
use App\Models\Order;
use App\Models\OrderVendorShippingWarehouse;
use App\Models\ShippingMethod;
use App\Models\ShippingType;
use App\Models\Transaction;
use App\Pipelines\Admin\Transaction\FilterCode;
use App\Pipelines\Admin\Transaction\FilterCustomer;
use App\Pipelines\Admin\Transaction\FilterDate;
use App\Pipelines\Admin\Transaction\FilterShippingMethod;
use App\Pipelines\Admin\Transaction\FilterShippingType;
use App\Pipelines\Admin\Transaction\FilterStatus;
use App\Pipelines\Admin\Transaction\FilterTracking;
use App\Services\ClientMessageService;
use App\Services\SendSms;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientMessage\UpdateClientMessage;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ClientSMSController extends Controller
{
    public function index(Request $request)
    {
        $statusValues = [OrderStatus::IN_SHIPPING, OrderStatus::PROCESSING, OrderStatus::CANCELED];

        $query = Order::with(['orderNote'])->where('status','!=',OrderStatus::WAITINGPAY);

        if (request()->get('status') != null && request()->get('status') != '') {
            $query = $query->where('status', request()->get('status'));
        }else{
            $query = $query->whereIn('status',$statusValues);
        }
        if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
        {
            $query =   $query->whereDate('orders.created_at','>=' ,request('from'))->whereDate('orders.created_at','<=' ,request('to'));
        }
        if (request()->has('shipping_type') && request('shipping_type') != '')
        {
            $search = request('shipping_type');
            $query->whereHas('orderVendorShippings', function($q) use($search){
                $q->where('shipping_type_id' , $search);
            });
        }
        if (request()->get('shipping_method') == 'none') {
            $query = $query->where('delivery_type',NULL);
        } elseif (request()->get('shipping_method') != null && request()->get('shipping_method') != '') {
            $query = $query->where('delivery_type', request()->get('shipping_method'));
        }

        $main_transactions = $query->descOrder()->paginate(10);
        $shipping_methods = ShippingMethod::all();
        $statuses = OrderStatus::getUnifiedStatusList();
        $shipping_types = ShippingType::all();
        $collection = ClientMessage::all();

        return view('admin.client-sms.index', ['main_transactions' => $main_transactions,'statuses' => $statuses,'shipping_types' => $shipping_types,'shipping_methods' => $shipping_methods,'collection' => $collection]);
    }

    public function sendsms(Request $request)
    {

        $statusValues = [OrderStatus::IN_SHIPPING, OrderStatus::PROCESSING, OrderStatus::CANCELED];

        $query = Order::with(['orderNote'])->where('status','!=',OrderStatus::WAITINGPAY);

        if (request()->get('status') != null && request()->get('status') != '') {
            $query = $query->where('status', request()->get('status'));
        }else{
            $query = $query->whereIn('status',$statusValues);
        }
        if (request()->has('from') && request('from') != '' && request()->has('to') && request('to') != '')
        {
            $query =   $query->whereDate('orders.created_at','>=' ,request('from'))->whereDate('orders.created_at','<=' ,request('to'));
        }

        if (request()->get('msg_type') != null && request()->get('msg_type') != '') {
            $msg_type = request()->get('msg_type');
        }

        if (request()->has('shipping_type') && request('shipping_type') != '')
        {
            $search = request('shipping_type');
            $query->whereHas('orderVendorShippings', function($q) use($search){
                $q->where('shipping_type_id' , $search);
            });
        }
        if (request()->get('shipping_method') == 'none') {
            $query = $query->where('delivery_type',NULL);
        } elseif (request()->get('shipping_method') != null && request()->get('shipping_method') != '') {
            $query = $query->where('delivery_type', request()->get('shipping_method'));
        }
        $main_transactions = $query->get();

        $clientMessage = ClientMessage::messageFor($msg_type)->first();
        if ($clientMessage) $msg = $clientMessage->getTransMessage("ar");

        $phoneNumber=array();
        foreach($main_transactions as $order){
            if($order->transaction->customer->phone){
                if ($msg_type == 'OnDeliveryTransaction') {
                    $userPortal = $order->transaction->client;
                    ClientMessageService::OnDeliveryTransaction(ClientMessageEnum::OnDeliveryTransaction, $userPortal, $order->code);
                }elseif ($msg_type == 'CompletedTransaction') {
                    $userPortal = $order->transaction->client;
                    ClientMessageService::completedTransaction(ClientMessageEnum::CompletedTransaction, $userPortal, $order->code, $order->transaction);
                }elseif ($msg_type == 'CompletedServiceTransaction') {
                    $userPortal = $order->transaction->client;
                    ClientMessageService::completedServiceTransaction(ClientMessageEnum::CompletedServiceTransaction, $userPortal, $order->code, $order->transaction);
                }elseif ($msg_type == 'CanceledTransaction') {
                    $userPortal = $order->transaction->client;
                    ClientMessageService::CanceledTransaction(ClientMessageEnum::CanceledTransaction, $userPortal, $order->code);
                }elseif ($msg_type == 'ReceiveTransaction') {
                    $userPortal = $order->transaction->client;
                    $orderWarehouses = $order->orderVendorShippingWarehouses()->where('shipping_type_id', 1)->get();
                    $old_id = null;
                    foreach ($orderWarehouses as $warehouse) {
                        //$code = $warehouse->receive_order_code;
                        $new_id = $warehouse->warehouse_id;
                        if($new_id!=$old_id){
                            $code = rand(1111, 9999);
                            $old_id = $new_id;
                        }
                        $warehouse->update(['receive_order_code' => $code]);
                        Log::notice('code: ' .$code. ' | Order ID: ' . $order->id);
                        ClientMessageService::receiveTransaction(ClientMessageEnum::ReceiveTransaction , $warehouse , $code, $userPortal , $order->code , $order->no_packages);
                    }
                }elseif ($msg_type == 'ReceiveServiceTransaction') {
                    $userPortal = $order->transaction->client;
                    $code = rand(1111, 9999);
                    $order->update(['receive_order_code' => $code]);
                    ClientMessageService::receiveServiceTransaction(ClientMessageEnum::ReceiveTransaction , $code, $userPortal , $order->code);
                }
            }
        }
        //Alert::success('SMS Sent',"SMS`s sent successfully");
        session()->flash('success', 'تم الإرسال بنجاح');
        return redirect()->route('admin.client-sms.index');

    }
}
