<?php

namespace App\Integrations\Shipping\Integrations\Torod;

use Illuminate\Support\Facades\Http;
use App\Exceptions\Integrations\Shipping\ErrorWhileLogin;
use App\Integrations\Shipping\Integrations\Traits\Logger;

class Login
{
    use Logger;

    /**
     * Api Endpoint to get access token.
     */
    const ENDPOINT = "token";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "torod-shipping";

    /**
     * Get shipment access_token.
     * This token is bearer token expires in 24 Hour.
     */
    public function __invoke() : string
    {
        $this->logger(self::LOG_CHANNEL, "TOROD:START_LOGIN", [], false);

        $response = Http::asForm()->withHeaders([
            "Accept" => "application/json"
        ])->post(config("shipping.torod.stage_url") . self::ENDPOINT, [
            "client_id" => config("shipping.torod.client_id"),
            "client_secret" => config("shipping.torod.client_secret")
        ]);

        $this->logger(self::LOG_CHANNEL, "TOROD:" . $response->json()["message"], $response->json(), $response->failed());

        if(!isset($response->json()["data"]["bearer_token"])) {
            throw new ErrorWhileLogin($response->json()["message"]);
        }

        return $response->json()["data"]["bearer_token"];
    }
}
