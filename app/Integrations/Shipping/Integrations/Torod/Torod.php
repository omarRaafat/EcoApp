<?php

namespace App\Integrations\Shipping\Integrations\Torod;

use App\Models\OrderShip;
use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Integrations\Shipping\Interfaces\ShippingIntegration;
use App\Integrations\Shipping\Integrations\Torod\DataValidationBeforApiCalls;

class Torod implements ShippingIntegration
{
    use Logger;

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "torod-shipping";

    /**
     * Start Shipping Process ...
     */
    public function createShipment(Transaction $transaction) : OrderShip
    {
        (new DataValidationBeforApiCalls)($transaction);
        
        $this->logger(self::LOG_CHANNEL, "TOROD:StartNewShipment", [], false);

        $transaction->load([
            "customer",
            "addresses.city",
            "products"
        ]);

        $orderShip = (new CreateShipment)($transaction);

        $this->logger(self::LOG_CHANNEL, "TOROD:Finishing_Shipping", $orderShip->toArray(), false);

        return $orderShip;
    }

    /**
     * Cancel Shipping Process ...
     */
    public function cancelShipment(Transaction $transaction) : array
    {
        $this->logger(self::LOG_CHANNEL, "TOROD:cancelShipment", [], false);
        $orderCancel = (new CancelOrder)($transaction);
        $this->logger(self::LOG_CHANNEL, "TOROD: " . $orderCancel["message"], $orderCancel, false);
        return $orderCancel;
    }
}