<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\ClientMessageEnum;
use App\Enums\ShippingMethods;
use App\Http\Controllers\Controller;
use App\Integrations\Shipping\Shipment;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderVendorShipping;
use App\Models\OrderVendorShippingWarehouse;
use App\Services\ClientMessageService;
use App\Services\SendSms;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;
class ShippingStatusController extends Controller
{
    //
    //    public function acceptedOrder(Request  $request , $pprove_order = 1){
    //        $order = Order::find($request->order_id);
    //        $order->update(['no_packages' => $request->no_packages ?? null]);
    //    }

    public function changeShippingStatus(Request $request, int $orderVendorShippingId = null, $new_status = null)
    {
        if ($request->has('order_status')) {
            $orderVendorShipping = OrderVendorShipping::where('id', $request->order_vendor_shipping_id)->first();
            if ($orderVendorShipping->order->status == 'canceled') {
                return back();
            }

            $orderVendorShipping->order->update(['status' => $request->order_status]);
            $orderVendorShipping->update(['status' => $request->order_status]);

            Alert::success(__('translation.order_updated_successfully'));
            return back();
        } else {
            if (request()->has('no_packages')) {
                $request->validate(
                    [
                        'no_packages' => 'required|numeric|min:1|max:1000',
                    ],
                    [
                        'no_packages.max' => 'عدد القطع التي ستقوم بتسليمها يجب ألا يتجاوز 1000 قطعة',
                    ],
                );

                $order = Order::find($request->order_id);
                $order->update(['no_packages' => $request->no_packages]);
            }

            if (($request->has('shipping_type_id') && $request->shipping_type_id == 1) || (!is_null($orderVendorShippingId) && !request()->has('no_packages'))) {
                DB::beginTransaction();
                $order_vendor_shipping_id = $orderVendorShippingId ?? $request->order_vendor_shipping_id;

                $status = $new_status ?? $request->shipping_status;

                $orderVendorShipping = OrderVendorShipping::where('id', $order_vendor_shipping_id)->first();
                if ($orderVendorShipping->order->status == 'canceled') {
                    return back();
                }

                $orderVendorShipping->update(['status' => $status]);
                $orderVendorShipping->order->update(['status' => $status]);

                $userPortal = $orderVendorShipping->order->transaction->client;
                if ($orderVendorShipping->status == 'processing') {
                    $orderWarehouse = OrderVendorShippingWarehouse::query()
                        ->where('order_ven_shipping_id', $orderVendorShipping->id)
                        ->where('shipping_type_id', $request->shipping_type_id)
                        ->where('vendor_id', $request->vendor_id)
                        ->get();
                    $code = rand(1111, 9999);
                    foreach ($orderWarehouse as $warehouse) {
                        $warehouse->update(['receive_order_code' => $code]);
                        ClientMessageService::receiveTransaction(ClientMessageEnum::ReceiveTransaction, $warehouse, $code, $userPortal, $orderVendorShipping->order->code, $orderVendorShipping->order->no_packages);
                    }
                } elseif ($orderVendorShipping->status == 'completed') {
                    if ($orderVendorShipping->order->status == 'completed') {
                        $orderVendorShipping->order->delivered_at = now();
                        $orderVendorShipping->order->save();
                    }

                    // send notification to user portal about order is delivered.
                    $invoice_number = rand(1111, 9999);
                    $orderVendorShipping->order->update(['invoice_number' => $invoice_number]);
                    ClientMessageService::completedTransaction(ClientMessageEnum::CompletedTransaction, $userPortal, $orderVendorShipping->order->code, $orderVendorShipping->transaction->id);

                    // UPDATE DELIVERED AT WHEN ORDERING IS COMPLETED
                }

                DB::commit();
                Alert::success(__('translation.order_updated_successfully'));
                return back();
            } else {
                $data = $request->all();
                $order_vendor_shipping = OrderVendorShipping::find($data['order_vendor_shipping_id']);
                if ($order_vendor_shipping->order->status == 'canceled' || $order_vendor_shipping->order->status == 'processing') {
                    return back();
                }

                if ($order_vendor_shipping->shipping_method_id == 1 && $data['is_accepted_shipping'] == 1) {
                    // ARAMEX CODE
                    $order_vendor_shipping->update(['is_accepted_shipping' => 1, 'status' => 'processing']);
                    $order_vendor_shipping->order->update(['status' => 'processing']);

                    $response = Shipment::make(ShippingMethods::ARAMEX)->createShipment($order_vendor_shipping->order, $order_vendor_shipping, ShippingMethods::ARAMEX);

                    if (isset($response['status']) && !$response['status']) {
                        Alert::error($response['message']);
                        return back();
                    }
                    $userPortal = $order_vendor_shipping->order->transaction->client;
                    ClientMessageService::OnDeliveryTransaction(ClientMessageEnum::OnDeliveryTransaction, $userPortal, $order_vendor_shipping->order->code);

                    Alert::success(__('translation.order_updated_successfully'));
                    return back();
                } elseif ($order_vendor_shipping->shipping_method_id == 2 && $data['is_accepted_shipping'] == 1) {
                    // SPL CODE

                    $order_vendor_shipping->update(['is_accepted_shipping' => 1, 'status' => 'processing']);
                    $order_vendor_shipping->order->update(['status' => 'processing']);

                    $response = Shipment::make(ShippingMethods::SPL)->createShipment($order_vendor_shipping->order, $order_vendor_shipping, ShippingMethods::SPL);

                    if (isset($response['status']) && !$response['status']) {
                        Alert::error($response['message']);
                        return back();
                    }
                    $userPortal = $order_vendor_shipping->order->transaction->client;
                    ClientMessageService::OnDeliveryTransaction(ClientMessageEnum::OnDeliveryTransaction, $userPortal, $order_vendor_shipping->order->code);

                    Alert::success(__('translation.order_updated_successfully'));
                    return back();
                }
                // $transaction = Transaction::query()->with(['addresses','city'])->find($request->order_vendor_shipping_id);
                // $shippingMethod = ShippingMethod::query()->find($request->shipping_method_id);
                // $method_key = ShippingMethodKeys::convertKeyToId($shippingMethod->integration_key);
                // Shipment::make($method_key)->createShipment($transaction);
            }
        }
    }

    public function checkOtp(Request $request)
    {
        try {
            $data = $request->validate(['otp' => 'required|numeric', 'order_id' => 'required|numeric|exists:orders,id']);
            $orderVendorShipping = OrderVendorShippingWarehouse::where('order_id', $data['order_id'])
                ->where('receive_order_code', $data['otp'])
                ->first();
            if ($orderVendorShipping && $orderVendorShipping->order->status != 'canceled') {
                return $this->changeShippingStatus($request, $orderVendorShipping->order_ven_shipping_id, 'completed');
            } else {
                Alert::error(__('admin.error'), __('admin.otp_or_order_no_found'));
            }
        } catch (Exception $e) {
            report($e);
            Alert::error(__('admin.error'), $e->getMessage());
        }
        return back();
    }

    public function serviceChangeShippingStatus(Request $request, int $orderId = null, $new_status = null)
    {
        if ($request->has('order_status')) {
            $order = OrderService::where('id', $request->order_id)->first();
            if ($order->status == 'canceled') {
                return back();
            }

            $order->update(['status' => $request->order_status]);

            Alert::success(__('translation.order_updated_successfully'));
            return back();
        } else {
            DB::beginTransaction();
            $order_id = $orderId ?? $request->order_id;

            $status = $new_status ?? $request->shipping_status;

            $order = OrderService::where('id', $order_id)->first();
            if ($order->status == 'canceled') {
                return back();
            }

            $order->update(['status' => $status]);

            $userPortal = $order->transaction->client;
            if ($order->status == 'processing') {
                $code = rand(1000, 9999);
                $order->update(['receive_order_code' => $code]);
                $userPortal = $order->transaction->client;
                ClientMessageService::receiveServiceTransaction(ClientMessageEnum::ReceiveServiceTransaction, $code, $userPortal, $order->code);
            } elseif ($order->status == 'completed') {
                // if($order->status == 'completed'){
                //     $order->delivered_at = now();
                //     $order->save();
                // }

                // send notification to user portal about order is delivered.
                $invoice_number = rand(1111, 9999);
                $order->update(['invoice_number' => $invoice_number]);
                ClientMessageService::completedServiceTransaction(ClientMessageEnum::CompletedServiceTransaction, $userPortal, $order->code, $order->transaction->id);
            }

            DB::commit();
            Alert::success(__('translation.order_updated_successfully'));
            return back();
        }
    }

    public function serviceCheckOtp(Request $request)
    {
        try {
            $data = $request->validate(['otp' => 'required|numeric', 'order_id' => 'required|numeric|exists:order_services,id']);
            $order = OrderService::where('id', $data['order_id'])
                ->where('receive_order_code', $data['otp'])
                ->first();
            if ($order && $order->status != 'canceled') {
                return $this->serviceChangeShippingStatus($request, $data['order_id'], 'completed');
            } else {
                Alert::error(__('admin.error'), __('admin.otp_or_order_no_found'));
            }
        } catch (Exception $e) {
            report($e);
            Alert::error(__('admin.error'), $e->getMessage());
        }
        return back();
    }
}
