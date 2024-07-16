<?php

namespace App\Integrations\Shipping\Integrations\Aramex;

use App\Exceptions\Integrations\Shipping\ErrorWhileLogin;
use Illuminate\Support\Facades\Http;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use Illuminate\Http\Response;

class Login
{
    use Logger;

    const ENDPOINT = "/token";

    const LOG_CHANNEL = "aramex-shipping";

    /**
     * @return string
     * @throws ErrorWhileLogin
     */
    public function __invoke() : string
    {
        $this->logger(self::LOG_CHANNEL, "ARAMEX:START_LOGIN", [], false);

        $response = Http::withHeaders(
            [
                'Content-Type' => 'text/html',
//                'Accept' => 'application/json',
            ]
        )->post('http://ws.dev.aramex.net/shippingapi/shipping/service_1_0.svc', [
            "UserName" => "reem@reem.com",
            "Password" => "123456789",
            "Version" => "1.0",
            "AccountNumber" => "4004636",
            "AccountPin" => "432432",
            "AccountEntity" => "RUH",
            "AccountCountryCode" => "SA"
        ]);

        dd("LOGIN" , $response);

//        $url = config("shipping.aramex.base_api_url") . self::ENDPOINT;
        $url = config("shipping.aramex.base_api_url");
        $data = [
//            "grant_type" => config("shipping.spl.grant_type"),
//            "UserName" => config("shipping.spl.username"),
//            "password" => config("shipping.spl.password")
//

            "UserName"              => config("shipping.aramex.UserName"),
            "Password"              => config("shipping.aramex.Password"),
            "Version"               => config('shipping.aramexVersion'), // v1
            "AccountNumber"         => config("shipping.aramex.AccountNumber"),
            "AccountPin"            => config("shipping.aramex.AccountPin"),
            "AccountEntity"         => config("shipping.aramex.AccountEntity"),
            "AccountCountryCode"    => config("shipping.aramex.AccountCountryCode"),
            "Source" => 24,
        ];
        $response = Http::asForm()->withHeaders(["Accept" => "application/json" , "Content-type" => "application/x-www-form-urlencoded"])->post($url, $data);
         dd("test Login in ARAMEX" , $response);

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
