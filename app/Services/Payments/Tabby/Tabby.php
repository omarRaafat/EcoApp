<?php

namespace App\Services\Payments\Tabby;




use App\Services\Payments\Tabby\Checkout;

class Tabby
{

    public function checkout($cart)
    {
        return (new Checkout)($cart);
    }

    public function cancel()
    {
        // TODO: Implement cancel() method.
    }

    public function refund()
    {
        // TODO: Implement refund() method.
    }
}
