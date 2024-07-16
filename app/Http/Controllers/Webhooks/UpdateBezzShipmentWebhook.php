<?php

namespace App\Http\Controllers\Webhooks;

use App\Models\OrderShip;
use App\Enums\OrderStatus;
use App\Events\Transaction as TransactionEvents;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateBezzShipmentWebhook extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function updateStatus(Request $request) : JsonResponse
    {
        Log::channel("bezz-warehouse-integration")->info("LOG_INCOMENING_REQUEST", $request->all());

        try {
            $validated = $this->_validateRequest($request);
        } catch (ValidationException $e) {
            return response()->json([
                "success" => false,
                "status" => "error",
                "message" => [
                    "type" => "error",
                    "code" => 400,
                    "name" => "REQUEST_BODY_HAS_VALIDATION_ERRORS",
                    "description" => $e->errors()
                ]
            ], 400);
        }

        [$tracking_id, $secret_key] = explode(",", $validated["tr"]);

        if($secret_key != config("shipping.bezz.bezz_webhook_secret_key")) {
            Log::channel("bezz-warehouse-integration")->info("UNVALID_SECRET_KEY", ["message" => "Unvaild Secret Key"]);
            return response()->json([
                "success" => false,
                "status" => "error",
                "message" => [
                    "type" => "error",
                    "code" => 400,
                    "name" => "UNVALID_SECRET_KEY",
                    "description" => "Unvaild Secret Key"
                ]
            ], 400);
        }

        $orderShip = OrderShip::where("gateway_tracking_id", $tracking_id)->first();

        if(!$orderShip) {
            Log::channel("bezz-warehouse-integration")->error("ORDER_SHIPING_NOT_FOUND", ["tracking_id" => $tracking_id]);

            return response()->json([
                "success" => false,
                "status" => "error",
                "message" => [
                    "type" => "error",
                    "code" => 400,
                    "name" => "ORDER_SHIPING_NOT_FOUND",
                    "description" => "This Shipment Not Assossiated To Any Order In our database."
                ]
            ], 400);
        }

        if(!$orderShip->transaction) {
            Log::channel("bezz-warehouse-integration")->error("ORDER_SHIPMENT_HAS_NO_TRANSACTION", ["tracking_id" => $tracking_id]);

            return response()->json([
                "success" => false,
                "status" => "error",
                "message" => [
                    "type" => "error",
                    "code" => 400,
                    "name" => "ORDER_SHIPMENT_HAS_NO_TRANSACTION",
                    "description" => "This Shipment Not Assossiated To Any Order In our database."
                ]
            ], 400);
        }

        $status = "";

        $transactionStateEvent = null;
        if($validated["status"] == "COCN" || $validated["status"] == "DD") {
            $status = OrderStatus::COMPLETED;
            $transactionStateEvent = new TransactionEvents\Delivered($orderShip->transaction->load("orders.vendor.wallet.transactions"));
        }

        if($validated["status"] == "RETDE" || $validated["status"] == "PREP" || $validated["status"] == "IT") {
            $status = OrderStatus::IN_DELEVERY;
            $transactionStateEvent = new TransactionEvents\OnDelivery($orderShip->transaction);
        }

        if(empty($status)) {
            Log::channel("bezz-warehouse-integration")->error("UNKNOWN_ORDER_STATUS_CODE: This status code has no mapping in our system", ["tracking_id" => $tracking_id, "status" => $validated["status"]]);

            return response()->json([
                "success" => false,
                "status" => "error",
                "message" => [
                    "type" => "error",
                    "code" => 400,
                    "name" => "UNKNOWN_ORDER_STATUS_CODE",
                    "description" => "Status Code Has No Map In Our System."
                ]
            ], 400);
        }

        $orderShip->transaction->update(["status" => $status]);
        if ($transactionStateEvent) event($transactionStateEvent);

        return response()->json([
            "success" => true,
            "status" => "success",
            "message" => [
                "type" => "success",
                "code" => 200,
                "name" => "SHIPMENT_UPDATED_SUCCESSFULLY",
                "description" => "Shipment Status Updated Successfully."
            ]
        ], 200);
    }

    /**
     * Validate Torod Request Body.
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function _validateRequest(Request $request) : array
    {
        $validator = Validator::make($request->all(), [
            "tr" => ["required"],
            "status" => ["required"],
            "created" => ["required"]
        ], [
            "tr.required" => "The 'tr' field is required",
            "status.required" => "The 'status' field is required",
            "created.required" => "The 'created' field is required"
        ]);

        if ($validator->fails()) {
            Log::channel("bezz-warehouse-integration")->error("LOG_INCOMENING_REQUEST", ["incomening_request" => $request->all(), "validation_errors" => $validator->errors()]);
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
