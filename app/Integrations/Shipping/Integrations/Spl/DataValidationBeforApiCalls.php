<?php

namespace App\Integrations\Shipping\Integrations\Spl;

use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Exceptions\Integrations\Shipping\CredentialsNotFound;
use App\Exceptions\Integrations\Shipping\AddressComponentNotFound;
use App\Models\Order;

class DataValidationBeforApiCalls
{
    use Logger;

    public $orderVendorShipping;
    public $shipping_method_id;

    const LOG_CHANNEL = "spl-shipping";

    /**
     * Check data validation before making any API call to SPL integration API
     * to avoid any failure through the shipment operation.
     * @throws CredentialsNotFound
     * @throws AddressComponentNotFound
     */
    public function __invoke(Order $order , $orderVendorShipping = null , $shipping_method_id = null) : void
    {
        $this->orderVendorShipping = $orderVendorShipping ;
        $this->shipping_method_id = $shipping_method_id ;
        $this->_checkIntegrationCredentialsExists();
        $this->isAddressDataValid($order);
    }

    /**
     * @throws CredentialsNotFound
     */
    private function _checkIntegrationCredentialsExists() : void
    {
        if(
            !config("shipping.spl.grant_type") || // change url in production to "shipping.torod.production_url"
            !config("shipping.spl.username") ||
            !config("shipping.spl.password") ||
            !config("shipping.spl.crm_account_id")
        ) {
            $this->logger(self::LOG_CHANNEL, "SPL:IntegrationCredentialsNotExists", [], true);
            throw new CredentialsNotFound();
        }
    }


    /**
     * @throws AddressComponentNotFound
     */
    private function isAddressDataValid(Order $order) : bool
    {
        $warehouse = $this->orderVendorShipping->orderVendorWarehouses()->where('shipping_method_id' , $this->shipping_method_id)->first()->warehouse;
        $msg = '';
        if (empty($order->transaction->client)) $msg = "Customer not exists";
        else if (!$order->transaction->city) $msg = "city not exists";
        // else if (!$transaction->addresses->description) $msg = "Address not exists";
        else if (empty($order->transaction->client->name)) $msg = "customer miss  name";
        // else if (!$transaction->addresses->last_name) $msg = "Address miss the last name";
        else if (empty($order->transaction->client->phone)) $msg = "customer miss  phone";
        // else if (!$transaction->addresses->city) $msg = "Address city not exists";
        // else if (!$transaction->addresses->city->spl_id) $msg = "Address city spl id not exists";
        // else if (!$transaction->addresses->country) $msg = "Address country not exists";
        // else if (!$transaction->addresses->country->spl_id) $msg = "Address country spl id not exists";
        // else if (!$warehouse) $msg = "Address country warehouse not exists";
        else if (!$warehouse) $msg = "warehouse not exists";

        if($msg) {
            $this->logger(self::LOG_CHANNEL, "SPL:_checkShippingAddressDataExists", [
                "first_name" => $order->transaction->client->name,
                "shpping_phone" =>  $order->transaction->client->phone,
                "shipping_city" =>  $order->transaction->city->name,
            ], true);
            throw new AddressComponentNotFound($msg);
        }

        return true;
    }
}
