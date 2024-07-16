<?php
namespace App\Integrations\Shipping\Integrations\Bezz;

use App\Exceptions\Integrations\Shipping\Bezz\ShipmentAlreadyCancelled;
use App\Exceptions\Integrations\Shipping\Bezz\ShipmentNotFound;
use App\Models\OrderShip;
use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Integrations\Shipping\Interfaces\ShippingIntegration;
use Exception;
use App\Exceptions\Integrations\Shipping\Bezz\ShipmentNotCreated;

class Bezz implements ShippingIntegration
{
    use Logger;

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-shipping";

    /**
     * @param Transaction $transaction
     * @return OrderShip
     * @throws ShipmentNotCreated
     */
    public function createShipment(Transaction $transaction) : OrderShip {
        (new DataValidationBeforApiCalls)($transaction);

        $this->logger(self::LOG_CHANNEL, "BEZZ:StartNewShipment", [], false);

        $transaction->load([
            "customer",
            "products",
            "addresses.city",
            "addresses.country.warehouseCountry.warehouse"
        ]);

        $orderShip = (new CreateShipment)($transaction);
        $this->logger(self::LOG_CHANNEL, "BEZZ:Finishing_Shipping", $orderShip->toArray(), false);

        return $orderShip;
    }

    /**
     * Cancel a transaction at Bezz Gateway
     * @param Transaction $transaction
     * @return array
     * @throws ShipmentAlreadyCancelled
     * @throws ShipmentNotFound
     * @throws Exception
     */
    public function cancelShipment(Transaction $transaction) : array
    {
        $this->logger(self::LOG_CHANNEL, "BEZZ:cancelShipment", [], false);
        $orderCancel = (new CancelOrder)($transaction);
        $this->logger(self::LOG_CHANNEL, "BEZZ: " . $orderCancel["message"], $orderCancel, false);
        return $orderCancel;
    }

    /**
     * @param Transaction $transaction
     * @return string
     * @throws ShipmentNotCreated
     */
    public static function shipmentApiCall(Transaction $transaction) : string
    {
        $self = new self;

        (new DataValidationBeforApiCalls)($transaction);

        $self->logger(self::LOG_CHANNEL, "BEZZ:StartNewShipment", [], false);

        $transaction->load([
            "customer",
            "products",
            "addresses.city",
            "addresses.country.warehouseCountry.warehouse"
        ]);

        $trackingNumber = (new CreateShipmentApiCall)($transaction);

        $self->logger(self::LOG_CHANNEL, "BEZZ:ShipmentApiCall , TrackingNumber:$trackingNumber", [], false);

        return $trackingNumber;
    }
}
