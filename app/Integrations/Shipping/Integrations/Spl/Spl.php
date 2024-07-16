<?php

namespace App\Integrations\Shipping\Integrations\Spl;

use App\Models\OrderShip;
use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Integrations\Shipping\Interfaces\ShippingIntegration;
use App\Models\Order;
use App\Models\OrderVendorShipping;
use Exception;

class Spl implements ShippingIntegration
{
    use Logger;

    const LOG_CHANNEL = "spl-shipping";


    public function createShipment(Order $order ,OrderVendorShipping $orderVendorShipping = null,int $shipping_method_id = null)
    {
        (new DataValidationBeforApiCalls)($order ,$orderVendorShipping, $shipping_method_id);

        $this->logger(self::LOG_CHANNEL, "SPL:StartNewShipment", [], false);

        // $order->load([
        //     "customer",
        //     "products",
        //     "addresses.country.warehouseCountry.warehouse"
        // ]);

        $response = (new CreateShipment)($order,$orderVendorShipping, $shipping_method_id);

//        $this->logger(self::LOG_CHANNEL, "SPL:Finishing_Shipping", $response['data']->toArray(), false);

        if($response['status']){
            return $response['data'];
        }else{
            return $response;
        }
    }

    /**
     * @param Order $order
     * @return array
     */
    public function cancelShipment(Order $order) : array
    {
        $this->logger(self::LOG_CHANNEL, "SPL:cancelShipment", [], false);
        $orderCancel = (new CancelOrder)($order);
        $this->logger(self::LOG_CHANNEL, "SPL: " . $orderCancel["message"], $orderCancel, false);
        return $orderCancel;
    }
}
