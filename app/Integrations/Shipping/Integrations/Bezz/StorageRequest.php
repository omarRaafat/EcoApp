<?php
namespace App\Integrations\Shipping\Integrations\Bezz;

use Illuminate\Support\Facades\Log;
use App\Models\WarehouseIntegration;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Models\VendorWarehouseRequest;
use App\Enums\WarehouseIntegration as Integration;
use App\Exceptions\Integrations\Warehouse\CredentialsEmpty;
use App\Exceptions\Integrations\Warehouse\VendorBeezIDEmpty;
use App\Exceptions\Integrations\Warehouse\Bezz\BezzApiException;
use App\Exceptions\Integrations\Warehouse\VendorWarehouseRequestEmpty;

class StorageRequest {

    /**
     * Endpoint
     */
    const ENDPOINT = "ClientStock/StockIn";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-warehouse-integration";

    /**
     * Create Bezz Warehouse Request
     */
    public function __invoke(VendorWarehouseRequest $vendorWarehouseRequest) : WarehouseIntegration
    {
        $this->_vaidateDataBeforApiCall($vendorWarehouseRequest);
        
        Log::channel(self::LOG_CHANNEL)->info("START_BEZZ_API_RESPONSE", []);

        $response = $this->_callWarehouseIntegrationApi($vendorWarehouseRequest);
        
        Log::channel(self::LOG_CHANNEL)->info("BEZZ_API_RESPONSE", ["API_RESPONSE" => $response]);

        if($response->json() == "Success") {
            Log::channel(self::LOG_CHANNEL)->info("SUCCESS_BEZZ_API_RESPONSE", ["API_RESPONSE" => $response]);

            return $this->_storeNewWarehouseIntegrationInfo($vendorWarehouseRequest, $response);
        }

        Log::channel(self::LOG_CHANNEL)->error("FAIL_BEZZ_API_RESPONSE", ["API_RESPONSE" => $response]);

        throw new BezzApiException;
    }

    /**
     * Create Api Call to bezz endpoint
     */
    private function _callWarehouseIntegrationApi(VendorWarehouseRequest $vendorWarehouseRequest) : Response
    {
        return Http::asForm()->withHeaders([
            "Accept" => 'application/json',
        ])->post(env("BEZZ_BASE_URL") . self::ENDPOINT, [
            "ApiKey" => env("BEZZ_API_KEY"),
            "AccountNumber" => env("BEZZ_ACCOUNT_NUMBER"),
            "Clientstocklist" => $this->_getProducts($vendorWarehouseRequest)
        ]);
    }

    /**
     * Store New Warehouse Integration in to our database.
     */
    private function _storeNewWarehouseIntegrationInfo(VendorWarehouseRequest $vendorWarehouseRequest, Response $response)
    {
        if(empty($vendorWarehouseRequest->warehouseIntegration)) {
            return WarehouseIntegration::create([
                "vendor_warehouse_request_id" => $vendorWarehouseRequest->id,
                "vendor_id" => $vendorWarehouseRequest->vendor->id, // beez vendor id that uses by bees warehouse integration
                "integration_name" => Integration::BEZZ
            ]);
        }

        return $vendorWarehouseRequest->warehouseIntegration;
    }

    /**
     * Handle products array before api call.
     */
    private function _getProducts(VendorWarehouseRequest $vendorWarehouseRequest) : array
    {
        $items = [];

        foreach($vendorWarehouseRequest->requestItems as $requestItem) {
            array_push($items, [
                "ProductName" => $requestItem->product->name,
                "Sku" => $requestItem->product->sku,
                "ReceivedQuantity" => $requestItem->qnt,
                "ClientId" => $vendorWarehouseRequest->vendor->beezConfig->beez_id
            ]);
        }

        return $items;
    }

    /**
     * Validate date before request
     */
    private function _vaidateDataBeforApiCall(VendorWarehouseRequest $vendorWarehouseRequest) : void
    {
        $vendorWarehouseRequest->vendor->load(['beezConfig']);

        if(
            !env("BEZZ_API_KEY") || 
            !env("BEZZ_API_KEY") ||
            !env("BEZZ_ACCOUNT_NUMBER")
        ) {
            throw new CredentialsEmpty;
        }

        if(
            !$vendorWarehouseRequest ||
            !$vendorWarehouseRequest->vendor ||
            $vendorWarehouseRequest->requestItems->count() <= 0
        ) {
            throw new VendorWarehouseRequestEmpty;
        }

        if(!$vendorWarehouseRequest->vendor->beezConfig) {
            throw new VendorBeezIDEmpty;
        }
    }
}