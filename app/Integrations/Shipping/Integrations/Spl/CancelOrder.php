<?php

namespace App\Integrations\Shipping\Integrations\Spl;

use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use Illuminate\Support\Facades\Http;

class CancelOrder
{
    use Logger;

    const ENDPOINT = "Orders/CancelOrder";

    const LOG_CHANNEL = "spl-shipping";

    /**
     * @todo The cancel order associated to spl under construction.
     * @param Transaction $transaction
     * @return array
     */
    public function __invoke(Transaction $transaction) : array
    {
        // $this->logger(self::LOG_CHANNEL, "SPL:START_CancelOrder", [], false);

        // $data = [];

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json'
        // ])->timeout(60)->post(config("shipping.SPL.base_url").self::ENDPOINT,$data);

        // if ($response->status() == 201 ||$response->status() == 200) {
        //     $message = ['message' => 'order cancel successfully'];
        // } elseif ($response->status() == 403) {
        //     $message = ['message'=>'order already been cancelled'];
        // } else {
        //     $message = ['message'=>'order not found to cancel'];
        // }

        // $this->logger(self::LOG_CHANNEL, "SPL: " .$message['message'] , $message, $response->failed());

        // return [
        //     'code' => $response->status(),
        //     "message" => $message['message'],
        //     "data" => $data
        // ];
        return [
            'code' => 404,
            'message' => 'Spl cancel order didn`t implemented',
            'data' => []
        ];
    }
}
