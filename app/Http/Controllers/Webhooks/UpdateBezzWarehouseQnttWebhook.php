<?php

namespace App\Http\Controllers\Webhooks;

use App\Enums\WarehouseIntegrationKeys;
use App\Models\Product;
use App\Models\OrderShip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ProductWarehouseStock;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateBezzWarehouseQnttWebhook extends Controller
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
            Log::channel("bezz-warehouse-integration")->info("VALIDATION_ERROR", ["beez_request" => $request->all(), "validation_errors" => $e->errors()]);
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

        if($validated["client_key"] != config("shipping.bezz.bezz_webhook_secret_key")) {
            Log::channel("bezz-warehouse-integration")->info("UNVALID_CLIENT_KEY", ["message" => "Unvaild Client Key"]);
            return response()->json([
                "success" => false,
                "status" => "error",
                "message" => [
                    "type" => "error",
                    "code" => 400,
                    "name" => "UNVALID_CLIENT_KEY",
                    "description" => "Unvaild Client Key"
                ]
            ], 400);
        }

        /**
         * TODO: Performance Check
         */
        $warehouse = Warehouse::where("api_key", WarehouseIntegrationKeys::NATIONAL_WAREHOUSE)->first();
        foreach($validated["BarcodeStock"] as $barcode) {
            $product = Product::where("sku", $barcode["barcode"])->first();
            if($product && $warehouse) {
                ProductWarehouseStock::updateOrCreate(
                    ['product_id' => $product->id, 'warehouse_id' => $warehouse->id],
                    ['stock' => $barcode["Quantity"]]
                );
                $product->update(["stock" => $product->warehouseStock()->sum('stock')]);
            } else if ($product) {
                Log::channel("bezz-warehouse-integration")->info("PRODUCT_WAREHOUSE_NOT_EXISTS", [
                    "warehouse_api_key" => WarehouseIntegrationKeys::NATIONAL_WAREHOUSE
                ]);
                $product->update(["stock" => $barcode["Quantity"]]);
            } else {
                Log::channel("bezz-warehouse-integration")->info("PRODUCT_NOT_EXISTS", [
                    "product_sku" => $barcode["barcode"]
                ]);
            }
        }

        return response()->json([
            "success" => true,
            "status" => "success",
            "message" => [
                "type" => "success",
                "code" => 200,
                "name" => "WAREHOUSE_PRODUCTS_QUANTITIES_UPDATED_SUCCESSFULLY",
                "description" => "Warehouse Products Quantities Successfully."
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
            "client_key" => ["required"],
            "QuantityUpdatedOn" => ["required", "date"],
            "BarcodeStock" => ["required", "array", "filled"],
            "BarcodeStock.*.barcode" => ["required"],
            "BarcodeStock.*.Quantity" => ["required"]
        ], [
            "client_key.required" => "client_key cannot be empty",
            "QuantityUpdatedOn.required" => "QuantityUpdatedOn  cannot be empty",
            "QuantityUpdatedOn.date" => "QuantityUpdatedOn  is not valid date",
            "BarcodeStock.required" => "BarcodeStock  cannot be empty",
            "BarcodeStock.array" => "BarcodeStock Must Be Array",
            "BarcodeStock.filled" => "BarcodeStock array cannot be empty",
            "BarcodeStock.*.barcode.required" => "This barcode cannot be empty",
            "BarcodeStock.*.Quantity.required" => "Thtis Quantity cannot be empty"
        ]);

        if ($validator->fails()) {
            Log::channel("bezz-warehouse-integration")->error("LOG_INCOMENING_REQUEST", ["incomening_request" => $request->all(), "validation_errors" => $validator->errors()]);
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
