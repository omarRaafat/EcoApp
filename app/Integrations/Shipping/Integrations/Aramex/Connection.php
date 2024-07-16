<?php

namespace App\Integrations\Shipping\Integrations\Aramex;

use Illuminate\Support\Facades\Http;

class Connection
{
    public function __invoke($data, $endpoint)
    {

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($endpoint, $data);

        dd($response);
    }
}
