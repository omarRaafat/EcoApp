<?php

namespace App\Integrations\Shipping\Integrations\Torod;

use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use App\Integrations\Shipping\Integrations\Traits\Logger;

class CreateOrder
{
    use Logger;

    /**
     * Api Endpoint to get order_id.
     */
    const ENDPOINT = "order/create";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "torod-shipping";
    
    /**
     * Get shipment order_id.
     */
    public function __invoke(Transaction $transaction) : array
    {
        $token = (new Login())();
        
        $this->logger(self::LOG_CHANNEL, "TOROD:START_CreateOrder", [], false);
        
        $response = Http::asForm()->withHeaders([
            "Accept" => 'application/json',
            "Authorization" => "Bearer " . $token
        ])->post(config("shipping.torod.stage_url") . self::ENDPOINT, [
            "name" => $transaction->addresses->first_name . " " . $transaction->addresses->last_name,
            "email" => $transaction->customer->email,
            "phone_number" => "966" . $transaction->addresses->phone,
            "item_description" => "dates",
            "order_total" => $transaction->total,
            "payment" => "Prepaid",
            "weight" => $transaction->products->pluck("weight_with_kilo")->sum(),
            "no_of_box" => 1,
            "type" => "address_city",
            "city_id" => $transaction->addresses->city->torod_city_id,
            "address" => $transaction->addresses->description
        ]);

        $this->logger(self::LOG_CHANNEL, "TOROD: " .$response->json()["message"] , $response->json(), $response->failed());
        
        return [
            "token" => $token,
            "message" => $response->json()["message"],
            "order_id" => $response->json()["data"]["order_id"]
        ];
    }
}