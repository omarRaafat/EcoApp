<?php

namespace App\Integrations\Shipping\Integrations\Torod;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Integrations\Shipping\Integrations\Traits\Logger;

class CancelOrder
{
    use Logger;

    /**
     * Api Endpoint to get order_id.
     */
    const ENDPOINT = "shipments/cancel";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "torod-shipping";
    
    /**
     * Get shipment order_id.
     */
    public function __invoke(Transaction $transaction) : array
    {
        $this->logger(self::LOG_CHANNEL, "TOROD:START_CancelOrder", [], false);
        
        $token = (new Login())();
        
        $response = Http::asForm()->withHeaders([
            "Accept" => 'application/json',
            "Authorization" => "Bearer " . $token
        ])->post(config("shipping.torod.stage_url") . self::ENDPOINT, [
            "tracking_or_order_id" => $transaction->orderShip->gateway_tracking_id
        ]);

        $this->logger(self::LOG_CHANNEL, "TOROD: " .$response->json()["message"] , $response->json(), $response->failed());
        
        return [
            "message" => $response->json()["message"],
            "data" => $response->json()
        ];
    }
}