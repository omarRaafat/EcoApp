<?php

namespace App\Services;

use App\Models\Vendor;
use Illuminate\Support\Facades\Http;
use App\Actions\ApiRequestAction;

class Alinma
{
    public static  function transfer(string $name  , $amount , $from , $to , $request_id)
    {
        $data = [
            "request_id"    => $request_id,
            "from_account"  => $from ,
            "to_account"    => $to,
            "amount"        => $amount,
            "full_name"     => $name
        ];
        $transferRoute = env('InmaTransferRoute' , "https://staging-api.ncpd.io/inma/fund/transfer");
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($transferRoute , $data);

        resolve(ApiRequestAction::class)->handle([
            'name' => 'InmaTransfer',
            'url' => $transferRoute,
            'req' => json_encode($data),
            'res' => $response->getBody()->getContents(),
            'http_code' => $response->status(),
        ]);

        return $response->json();
    }
}
