<?php

namespace App\Integrations\Shipping\Integrations\Torod;

use App\Models\OrderShip;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use App\Enums\WarehouseIntegrationKeys;
use App\Integrations\Shipping\Integrations\Traits\Logger;

class CreateShipment
{
    use Logger;

    /**
     * Api Endpoint to get create shipment.
     */
    const ENDPOINT = "order/ship/process";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "torod-shipping";

    const SHIPPING_TYPE = "cold";

    /**
     * Create New Shipment.
     */
    public function __invoke(Transaction $transaction) : OrderShip
    {
        $createOrderResponse = (new CreateOrder())($transaction);
     
        $this->logger(self::LOG_CHANNEL, "TOROD:CreateShipment", [], false);

        $warehouse = Warehouse::where("integration_key", WarehouseIntegrationKeys::NATIONAL_WAREHOUSE)->first();
        // TODO: need to be refactored according to new business for domestic zone
        // $courier_partner_id = $transaction->addresses->city->domesticZones->torodCompany->torod_courier_id;
        
        $response = Http::asForm()->withHeaders([
            "Accept" => 'application/json',
            "Authorization" => "Bearer " . $createOrderResponse["token"]
        ])->post(config("shipping.torod.stage_url") . self::ENDPOINT, [
            "order_id" => $createOrderResponse["order_id"],
            "warehouse" => $warehouse->torod_warehouse_name,
            "type" => self::SHIPPING_TYPE,
            // "courier_partner_id" => $courier_partner_id
        ]);
        
        $this->logger(self::LOG_CHANNEL, "TOROD: " . $response->json()["message"] , $response->json(), $response->failed());

        return $this->_createOrderShip(
            $transaction,
            $createOrderResponse["order_id"],
            $response->json()["data"]["tracking_id"],
            $response->json()["data"]["aws_label"]
        );
    }

    /**
     * Create new OrderShip.
     */
    private function _createOrderShip(Transaction $transaction, string $order_id, string $tracking_id, string $aws_label) : OrderShip
    {
        return OrderShip::create([
            "reference_model" => get_class($transaction),
            "reference_model_id" => $transaction->id,
            "gateway_order_id" => $order_id,
            "gateway_tracking_id" => $tracking_id,
            "gateway_tracking_url" => $aws_label
        ]);
    }
}