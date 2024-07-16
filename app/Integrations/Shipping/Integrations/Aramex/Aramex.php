<?php

namespace App\Integrations\Shipping\Integrations\Aramex;

use App\Exceptions\Integrations\Shipping\Aramex\ShipmentNotCreated;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Integrations\Shipping\Interfaces\ShippingIntegration;
use App\Models\Order;
use App\Models\OrderShip;
use App\Models\OrderVendorShipping;
use App\Models\Transaction;
use Exception;

class Aramex implements ShippingIntegration
{

    use Logger;

    const LOG_CHANNEL = "aramex-shipping";


    /**
     * @param  Order $order
     * @param  OrderVendorShipping|null $orderVendorShipping
     * @param  int|null $shipping_method_id
     * @return OrderShip
     * @throws ShipmentNotCreated
     */
    public function createShipment(Order $order , OrderVendorShipping $orderVendorShipping = null, int $shipping_method_id = null)
    {
        (new DataValidationBeforApiCalls)($order ,$orderVendorShipping, $shipping_method_id);

        $this->logger(self::LOG_CHANNEL, "ARAMEX:StartNewShipment", [], false);

//        $order->load([
//            "customer",
//            "products",
//            "addresses.country.warehouseCountry.warehouse"
//        ]);

        $response = (new CreateShipment)($order,$orderVendorShipping, $shipping_method_id);

        if(empty($response)){
            return ['status' => false, 'message' => 'خطأ فى شحن أرامكس!'];
        };

        if(isset($response['status']) && $response['status']){
            return $response['data'];
        }
        
        return $response;
    }

    /**
     * @param Order $order
     * @return array
     */
    public function cancelShipment(Order $order) : array
    {
        $this->logger(self::LOG_CHANNEL, "ARAMEX:cancelShipment", [], false);
        $orderCancel = (new CancelOrder)($order);
        $this->logger(self::LOG_CHANNEL, "ARAMEX: Order:". $order->id. '('. $order->code .') message:' . $orderCancel["message"], $orderCancel, false);
        return $orderCancel;
    }

    public function RefundShipment(Order $order , OrderVendorShipping $orderVendorShipping = null, int $shipping_method_id = null)
    {
        (new DataValidationBeforApiCalls)($order ,$orderVendorShipping, $shipping_method_id);

        $this->logger(self::LOG_CHANNEL, "ARAMEX:StartNewRefundShipment", [], false);

        $response = (new RefundShipment)($order,$orderVendorShipping, $shipping_method_id);

        if($response['status']){
            return $response['data'];
        }else{
            $this->logger(self::LOG_CHANNEL, "ARAMEX: Order:". $order->id. '('. $order->code .') message:' . $response["message"], $response, false);

            return $response;
        }
    }
}
