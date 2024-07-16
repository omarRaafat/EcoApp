<?php

namespace App\Integrations\Shipping\Interfaces;

use App\Models\Order;
use App\Models\OrderVendorShipping;
use App\Models\Transaction;

interface ShippingIntegration
{
    /**
     * Start Shipping Process ...
     */
    public function createShipment(Order $order , OrderVendorShipping $orderVendorShipping = null , int $shipping_method_id  = null);

    /**
     * Cancel Shipping Process ...
     */
    public function cancelShipment(Order $order);
}