<?php

namespace App\Integrations\Shipping\Integrations\Spl;

use App\Exceptions\Integrations\Shipping\ErrorWhileLogin;
use Illuminate\Support\Facades\Http;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use Illuminate\Http\Response;

class Login
{
    use Logger;

    const ENDPOINT = "token";

    const LOG_CHANNEL = "spl-shipping";

    /**
     * @return string
     * @throws ErrorWhileLogin
     */
    public function __invoke() : string
    {
        $this->logger(self::LOG_CHANNEL, "SPL:START_LOGIN", [], false);

        $url = config("shipping.spl.base_api_url") . self::ENDPOINT;
        $data = [
            "grant_type" => config("shipping.spl.grant_type"),
            "UserName" => config("shipping.spl.username"),
            "password" => config("shipping.spl.password")
        ];
        
        $response = Http::asForm()->withHeaders(["Accept" => "application/json"])->post($url, $data);
        // dd($response);

        if ($response->status() != Response::HTTP_OK) {
            $this->logger(self::LOG_CHANNEL, "SPL:Login 404", ['body' => $response->body()], $response->failed());
            throw new ErrorWhileLogin("Login Endpoint is not found anymore, using this url: {}");
        } else if ($response->failed() || ($response->json()["error"] ?? false)) {
            $this->logger(self::LOG_CHANNEL, "SPL: Get Access Token Failed", ['body' => ($response->json() ?? [])], $response->failed());
            $msg = $response->json()["error"] ?? "Can`t login to SPL at current time";
            throw new ErrorWhileLogin($msg);
        }
        $this->logger(self::LOG_CHANNEL, "SPL: Get Access Token", $response->json() ?? [], $response->failed());

        return $response->json()["access_token"];
    }
}
