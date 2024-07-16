<?php

namespace App\Http\Controllers\Webhooks;

use App\Models\WebHook;
use App\Models\OrderShip;
use App\Enums\OrderStatus;
use App\Enums\CustomHeaders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OrderStatusLog;
use App\Enums\ClientMessageEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ClientMessageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Events\Transaction as TransactionEvents;
use App\Models\OrderShipStatusLog;

class AramexShipmentWebhook extends Controller
{

    const LOG_CHANNEL = "Aramex-shipping";

    public function shipmentStatus(Request $request)
    {
        try {
            Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:LOG_INCOMING_REQUEST WEBHOOK", $request->all());
            $this->isAuth($request);

            $data = $this->isValidateRequest($request);
            //            $data = $request->all();

            //            dd($data['Value']);
            $orderShip = OrderShip::with(['order' => function ($o) {
                $o->with(['transaction' => function ($t) {
                    $t->with('customer');
                }, 'vendor']);
            }])->where("gateway_tracking_id", $data["Value"]['WaybillNumber'])->first();

            $webhook = WebHook::create([
                'name' => 'AramexShipmentWebhook',
                'payload' => json_encode($request->all())
            ]);

            if ($orderShip && $orderShip->order) {
                $status = $transactionEvent = null;
                switch ($data["Value"]['UpdateCode'] ?? "") {
                    case "SH012": //Shipment Picked Up
                    case "SH047": //Shipment Picked Up
                        $status = OrderStatus::PICKEDUP;
                        $orderShipStatus = OrderStatus::PICKEDUP;
                        break;
                    case "SH001": //Shipment Out for Delivery
                    case "SH002": //Shipment Out for Delivery
//                    case "SH003": //Shipment Out for Delivery
//                    case "SH022": //Shipment Out for Delivery
//                    case "SH033": //Shipment Out for Delivery
//                    case "SH044": //Shipment Out for Delivery
//                    case "SH070": //Shipment Out for Delivery
//                    case "SH076": //Shipment Out for Delivery
//                    case "SH077": //Shipment Out for Delivery
//                    case "SH110": //Shipment Out for Delivery
//                    case "SH249": //Shipment Out for Delivery
//                    case "SH259": //Shipment Out for Delivery
//                    case "SH164": //Shipment Out for Delivery
//                    case "SH260": //Shipment Out for Delivery
//                    case "SH270": //Shipment Out for Delivery
//                    case "SH271": //Shipment Out for Delivery
//                    case "SH273": //Shipment Out for Delivery
//                    case "SH295": //Shipment Out for Delivery
//                    case "SH296": //Shipment Out for Delivery
//                    case "SH369": //Shipment Out for Delivery
                        $status = OrderStatus::IN_SHIPPING;
                        $orderShipStatus = 'confirmed';
                        break;
                    case "SH006":
                    case "SH496":
                    case "SH005": //Delivered CODE
                        $status = OrderStatus::COMPLETED;
                        $transactionEvent = new TransactionEvents\Delivered($orderShip->order);
                        $orderShipStatus = 'delivered';
                        break;
                }

                if ($status) {
                    if ($status != $orderShip->order->status) {
                        if (!in_array($orderShip->order->status,[OrderStatus::REFUND,OrderStatus::COMPLETED,OrderStatus::CANCELED])) {
                            $webhook->update([
                                'dataUpdated' => [
                                    'order_id' => $orderShip->order->id,
                                    'old' => $orderShip->order->status,
                                    'new' => $status,
                                ]
                            ]);

                            // UPDATE ORDER STATUS TO DELIVERED OR SHIPPED FROM ARAMEX CASES CODES
                            $orderShip->order->status = $status;
                            $orderShip->order->save();

                            #update orderVendorShippings
                            $orderShip->order->orderVendorShippings()->update(['status' => $status]);
                            #update orderShip
                            $orderShip->update(['status' => $orderShipStatus]);
                            #update transaction
                            $transaction = $orderShip->order->transaction;
                            if ($transaction->orders()->whereNotIn('status', ['completed'])->doesntExist() ||
                                $transaction->orders()->whereIn('status', ['completed', 'canceled'])->count() === $transaction->orders()->count() ||
                                $transaction->orders()->whereIn('status', ['completed', 'refund'])->count() === $transaction->orders()->count()) {
                                $transaction->update(['status' => 'completed']);
                            }


                            if ($orderShipStatus == 'delivered') {
                                // UPDATE ORDER DELIVERED_AT WHEN COMPLETED AND DELIVERED | SHIPPING VIA ARAMEX
                                $orderShip->order->delivered_at = now();
                                $orderShip->order->save();
                                // $userPortal = $orderShip->order->transaction->getCustomerFromPortal();
                                $userPortal = $orderShip->order->transaction->client;
                                ClientMessageService::completedTransaction(ClientMessageEnum::CompletedTransaction, $userPortal, $orderShip->order->code, $orderShip->order->transaction->id);
                                // OrderStatusLog::create([
                                //     'order_id' => $orderShip->order->id,
                                //     'status' => $orderShip->order->status,
                                //     'created_by' => auth()->check() ? auth()->user()->id : null,
                                //  ]);
                            }

                            if ($orderShipStatus == OrderStatus::PICKEDUP && is_null($orderShip->order->pickup_at)) {
                                $orderShip->order->pickup_at = now();
                                $orderShip->order->save();
                            }

                            if ($transactionEvent) {
                                event($transactionEvent);
                            } else {
                                Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:MISSED_EVENT", array_merge(['orderShip' => $orderShip->id, 'status' => $status], $data["Value"]));
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
                    Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:MISSED_STATUS", array_merge(['orderShip' => $orderShip->id], $data["Value"]));
                    //  return $this->failureResponse("Shipment-Status:MISSED_STATUS" , 422);
                }
            } else {
                Log::channel(self::LOG_CHANNEL)->info("Shipment-Status:MISSED_ORDER_SHIP_OR_TRANSACTION", $data["Value"]);
                return $this->failureResponse("Not Found Waybill number", 422);
            }

            return response()->json(["Status" => true, "StatusDescription" => "Success"]);
        } catch (ValidationException $ex) {
            return $this->failureResponse($ex->getMessage());
        }
    }

    /**
     * @param  $msg
     * @param  int $statusCode
     * @return JsonResponse
     */
    private function failureResponse($msg = null, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(["Status" => false, "StatusDescription" => empty($msg) ? "fail" : $msg], $statusCode);
    }


    /**
     * @param  Request $request
     * @return array|JsonResponse
     * @throws ValidationException
     */
    private function isValidateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "Key"                       => ["required"],
            "Value"                     => ["required", "array"],
            "Value.WaybillNumber"     => ["required", "max:250"],
            "Value.UpdateCode"        => ["required", "max:250"],
            //  "Value.UpdateDateTime"    => ["required", "max:250"],
            "Value.Comments"          => ["nullable", "max:250"],
            "Value.ProblemCode"       => ["nullable", "max:250"],
            "Value.OrderNumber"       => ["nullable", "max:250"],
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
    private function isAuth(Request $request): void
    {
        if ($request->header(CustomHeaders::ARAMEX_API_TOKEN) != config("shipping.aramex.shipment_status_token")) {
            Log::channel(self::LOG_CHANNEL)->error("Shipment-Status:AUTH_FAIL", ["token" => $request->bearerToken()]);
            throw new AuthenticationException;
        }
    }
}
