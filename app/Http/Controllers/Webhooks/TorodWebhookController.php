<?php

namespace App\Http\Controllers\Webhooks;

use App\Models\OrderShip;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TorodWebhookController extends Controller
{
    /**
     * Webhook that update shipment status when torod post new status to this api.
     */
    public function updateStatus(Request $request) : JsonResponse
    {
        Log::channel("torod-webhooks")->info("LOG_INCOMENING_REQUEST", $request->all());

        try {
            $validated = $this->_validateTorodRequest($request);
        } catch(ValidationException $e) {
            return response()->json([
                "success" => true,
                "status" => 400,
                "data" => $e->errors()
            ], 400);
        }
        
        $orderShip = OrderShip::where("gateway_order_id", $validated["order_id"])->where("gateway_tracking_id", $validated["tracking_id"])->first();

        if(!$orderShip) {
            Log::channel("torod-webhooks")->error("ORDER_SHIPING_NOT_FOUND", ["order_id" => $validated["order_id"], "tracking_id" => $validated["tracking_id"]]);

            return response()->json([
                "success" => true,
                "status" => 400,
                "data" => [
                    "message" => "This Shipment Not Assossiated To Any Order In our database."
                ]
            ], 400);
        }

        if(!$orderShip->transaction) {
            Log::channel("torod-webhooks")->error("ORDER_SHIPMENT_HAS_NO_TRANSACTION", ["order_id" => $validated["order_id"], "tracking_id" => $validated["tracking_id"]]);

            return response()->json([
                "success" => true,
                "status" => 400,
                "data" => [
                    "message" => "This Shipment Not Assossiated To Any Order In our database."
                ]
            ], 400);
        }

        /**
         * TODO: This status mapping must handled by Eng. Ahmed Hesham.
         */
        if($validated["torod_description_ar"] == "جاهز للشحن" || $validated["torod_description_ar"] == "جاري التوصيل") {
            $orderShip->transaction->update(["status" => OrderStatus::IN_DELEVERY]);
        } elseif($validated["torod_description_ar"] == "تم التوصيل") {
            $orderShip->transaction->update(["status" => OrderStatus::COMPLETED]);
        } else {
            Log::channel("torod-webhooks")->error("UNKNOWN_SHIPPING_ORDER", ["order_id" => $validated["order_id"], "tracking_id" => $validated["tracking_id"], "torod_description_ar" => $validated["torod_description_ar"]]);

            return response()->json([
                "success" => true,
                "status" => 400,
                "data" => [
                    "message" => "Unknown Shipping Description"
                ]
            ], 400);
        }

        Log::channel("torod-webhooks")->error("UNKNOWN_SHIPPING_ORDER", ["shipOrder" => $orderShip->toArray(), "transaction" => $orderShip->transaction->toArray(), "torod_request" => $validated]);

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Shipment Status Updated Successfully."
        ], 200);
    }

    /**
     * Validate Torod Request Body.
     */
    private function _validateTorodRequest(Request $request) : array
    {
        $validator = Validator::make($request->all(), [
            "order_id" => ["required"],
            "tracking_id" => ["required"],
            "torod_description" => ["required"],
            "torod_description_ar" => ["required"]
        ], [
            "order_id.required" => "The order_id field is required.",
            "tracking_id.required" => "The tracking_id field is required.",
            "torod_description.required" => "The torod_description field is required.",
            "torod_description_ar.required" => "The torod_description_ar field is required.",
        ]);

        if ($validator->fails()) {
            Log::channel("torod-webhooks")->error("LOG_INCOMENING_REQUEST", ["incomening_request" => $request->all(), "validation_errors" => $validator->errors()]);
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
