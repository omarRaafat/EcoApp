<?php

namespace App\Http\Controllers\Webhooks;

use App\Enums\ClientMessageEnum;
use App\Enums\CustomHeaders;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\OrderShip;
use App\Services\ClientMessageService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Events\Transaction as TransactionEvents;
use App\Models\WebHook;
use App\Models\OrderShipStatusLog;

class SplShipmentWebhook extends Controller
{
    const LOG_CHANNEL = "spl-shipping";

    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function shipmentStatus(Request $request) : JsonResponse
    {
        try {
            Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:LOG_INCOMING_REQUEST", $request->all());
            $this->isAuth($request);
            $data = $this->isValidateRequest($request);
            foreach ($data["messages"] as $row) {

                $orderShip = OrderShip::with(['order' =>function($o){
                    $o->with(['transaction' => function($t){
                        $t->with('customer');
                    } , 'vendor']);
                } ])->where("gateway_tracking_id", 'like', $row['ItemCode'])->first();

                $webhook = WebHook::create([
                    'name' => 'SplShipmentWebhook',
                    'payload' => json_encode($request->all())
                ]);
        
                if ($orderShip && $orderShip->order) {
                    $status = $transactionEvent = null;
                    switch ($row['MainEvent_Code'] ?? "") {
                        case "1": //Shipment Picked Up
                            $status = OrderStatus::PICKEDUP;
                            $orderShipStatus = OrderStatus::PICKEDUP;
                            break;
                        case "3": //Under transportation
                            $status = OrderStatus::IN_SHIPPING;
                            $orderShipStatus = 'confirmed';
                            break;
                        case "4": //Under delivery
                            $status = OrderStatus::IN_SHIPPING;
                            $transactionEvent = new TransactionEvents\OnDelivery($orderShip->order);
                            $orderShipStatus = 'confirmed';
                            // $transactionEvent = new TransactionEvents\OnDelivery($orderShip->transaction);
                            break;
                        case "5": //Delivered
                            $status = OrderStatus::COMPLETED;
                            $transactionEvent = new TransactionEvents\Delivered($orderShip->order);
                            $orderShipStatus = 'delivered';
                            break;
                    }


                    if ($status) {
                        if ($status != $orderShip->order->status) {
                            if(!in_array($orderShip->order->status,[OrderStatus::REFUND,OrderStatus::COMPLETED,OrderStatus::CANCELED])){
                                $webhook->update([
                                    'dataUpdated' => [
                                        'order_id' => $orderShip->order->id,
                                        'old' => $orderShip->order->status,
                                        'new' => $status,
                                    ]
                                ]);
                                
                                $orderShip->order->status = $status;
                                $orderShip->order->save();

                                #update orderVendorShippings
                                $orderShip->order->orderVendorShippings()->update(['status' => $status]);
                                #update orderShip
                                $orderShip->update(['status' => $orderShipStatus]);

                                if($orderShipStatus == 'delivered'){
                                    $orderShip->order->delivered_at = now();
                                    $orderShip->order->save();
                                    $userPortal = $orderShip->order->transaction->client;
                                    ClientMessageService::completedTransaction(ClientMessageEnum::CompletedTransaction , $userPortal , $orderShip->order->code , $orderShip->order->transaction->id);
                                }
                                if ($transactionEvent) {
                                    event($transactionEvent);
                                } else {
                                    Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:MISSED_EVENT", array_merge(['orderShip' => $orderShip->id, 'status' => $status], $row));
                                }       
                            }else{
                                OrderShipStatusLog::create([
                                    'order_id' => $orderShip->order->id,
                                    'old_status' => $orderShip->order->status,
                                    'new_status' => $status,
                                    'status' => 'not_applied',
                                ]);
                            }
                        }
                    } else {
                        Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:MISSED_STATUS", array_merge(['orderShip' => $orderShip->id], $row));
                    }
                } else {
                    Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:MISSED_ORDER_SHIP_OR_TRANSACTION", $row);
                }
            }
            return response()->json(["Status" => "0", "StatusDescription" => "Success"]);
        } catch (ValidationException | AuthenticationException $e) {
            return $this->failureResponse();
        }
    }

    private function failureResponse() : JsonResponse {
        return response()->json(["Status" => "1", "StatusDescription" => " fail"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function isValidateRequest(Request $request) : array
    {
        $validator = Validator::make($request->all(), [
            "messages" => ["required", "array"],
            "messages.*.ItemCode" => ["required", "max:250"],
            "messages.*.MainEvent_Code" => ["required", "max:250"],
        ]);

        if ($validator->fails()) {
            Log::channel(self::LOG_CHANNEL)
                ->error("Shipment-Status:VALIDATION_LOG_INCOMING_REQUEST", [
                    "request" => $request->all(), "validation_errors" => $validator->errors()
                ]);
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    /**
     * @param Request $request
     * @return void
     * @throws AuthenticationException
     */
    private function isAuth(Request $request) : void
    {
        if ($request->header(CustomHeaders::SPL_API_TOKEN) != config("shipping.spl.shipment_status_token")) {
            Log::channel(self::LOG_CHANNEL)->error("Shipment-Status:AUTH_FAIL", ["token" => $request->bearerToken()]);
            throw new AuthenticationException;
        }
    }
}
