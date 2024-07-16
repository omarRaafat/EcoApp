<?php

namespace App\Integrations\Shipping\Integrations\Aramex;

use App\Models\Order;
use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use Illuminate\Support\Facades\Http;
use App\Actions\ApiRequestAction;

class CancelOrder
{
    use Logger;

    const ENDPOINT = "Orders/CancelOrder";

    const LOG_CHANNEL = "aramex-shipping";

    /**
     * @todo The cancel order associated to aramex under construction.
     * @param Transaction $transaction
     * @return array
     */
    public function __invoke(Order $order) : array
    {
        try {
            $guid  = isset($order->orderShip()->first()->extra_data) ? json_decode($order->orderShip()->first()->extra_data) : NULL;
            if (isset($guid) &&  $guid != '')
            {
                $guid  = $guid->GUID;
                $data = [
                    "ClientInfo" => $this->clientInfo(),
                    'PickupGUID' => $guid,
                    'Comments' => 'test',
                    "Transaction" => [
                        "Reference1" => $order->id,
                        "Reference2" => $order->code,
                        "Reference3" => "",
                        "Reference4" => "",
                        "Reference5" => ""
                    ]
                ];
                $url = config('shipping.aramex.ARAMEXCANCELURL');
                $responseee = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->post($url, $data);

                resolve(ApiRequestAction::class)->handle([
                    'name' => 'AramexCancelShipment',
                    'model_name' => 'Order',
                    'model_id' => $order->id,
                    'client_id' => $order->transaction->customer_id,
                    'url' => $url,
                    'req' => json_encode($data),
                    'res' => $responseee->getBody()->getContents(),
                    'http_code' => $responseee->status(),
                ]);

                if($responseee->json()['HasErrors']){
                    return ['status' => false , 'message' => $responseee->json()['Message']];
                }
            }else{
                return ['status' => false , 'message' => 'not found shipping'];

            }
            return ['status' => true , 'message' => 'success'];
        } catch (\Throwable $th) {
            report($th);
            return ['status' => false , 'message' => '  خطا إلغاء شحنة!'];
        }

    }

    private static function clientInfo() : array
    {
        return [
            "UserName"=> 'armx.ruh.it@gmail.com',
            "Password"=> config("shipping.aramex.Password"),
            "Version"=> config("shipping.aramex.Version"),
            "AccountNumber"=> config("shipping.aramex.AccountNumber"),
            "AccountPin"=> config("shipping.aramex.AccountPin"),
            "AccountEntity"=> config("shipping.aramex.AccountEntity"),
            "AccountCountryCode"=> config("shipping.aramex.AccountCountryCode"),
            "Source"=> config("shipping.aramex.Source")
        ];
    }
}
