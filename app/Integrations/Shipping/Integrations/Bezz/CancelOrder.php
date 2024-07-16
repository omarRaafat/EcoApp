<?php

namespace App\Integrations\Shipping\Integrations\Bezz;

use App\Exceptions\Integrations\Shipping\Bezz\ShipmentAlreadyCancelled;
use App\Exceptions\Integrations\Shipping\Bezz\ShipmentNotFound;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use Exception;

class CancelOrder
{
    use Logger;

    /**
     * Api Endpoint to get order_id.
     */
    const ENDPOINT = "Orders/CancelOrder";

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-shipping";

    /**
     * Cancel a transaction at Bezz Gateway
     * @param Transaction $transaction
     * @return array
     * @throws ShipmentAlreadyCancelled
     * @throws ShipmentNotFound
     * @throws Exception
     */
    public function __invoke(Transaction $transaction): array
    {
        $this->logger(self::LOG_CHANNEL, "BEZZ:START_CancelOrder", [], false);
        $accountNumber = config("shipping.bezz.acccount_number");
        $apiKey = config("shipping.bezz.api_key");

        if (is_null($accountNumber) || is_null($apiKey)) throw new Exception("Bezz credentials can`t be empty, please set them as env variables");

        $data = [
            'OrderNumber' => $transaction->code,
            'AccountNumber' => $accountNumber,
            'ApiKey' => $apiKey,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->timeout(60)->post(config("shipping.bezz.base_url").self::ENDPOINT, $data);

        $exception = null;
        if ($response->status() == 201 || $response->status() == 200) {
            $message = ['message' => 'order cancel successfully'];
        } elseif ($response->status() == 403) {
            $message = ['message' => 'order already been cancelled'];
            $exception = new ShipmentAlreadyCancelled();
        } else {
            $message = ['message' => 'order not found to cancel'];
            $exception = new ShipmentNotFound();
        }

        $this->logger(self::LOG_CHANNEL, "BEZZ: ".$message['message'], $message, $response->failed());
        if ($exception) throw $exception;

        return [
            'code' => $response->status(),
            "message" => $message['message'],
            "data" => $data
        ];
    }
}
