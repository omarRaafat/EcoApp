<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Integrations\Payment\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout($method = 4)
    {
        $response = (new Payment)->make($method)->checkout();
        return $response;

    }
}
