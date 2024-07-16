<?php
namespace App\Integrations\Shipping\Integrations\Aramex;

use App\Models\Order;
use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Exceptions\Integrations\Shipping\CredentialsNotFound;
use App\Exceptions\Integrations\Shipping\AddressComponentNotFound;

class DataValidationBeforApiCalls
{
    use Logger;

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "aramex-shipping";


    public function __invoke(Order $order , $orderVendorShipping = null , $shipping_method_id = null) : void
    {
        $this->orderVendorShipping = $orderVendorShipping ;
        $this->shipping_method_id = $shipping_method_id ;
        $this->_checkIntegrationCredentialsExists();
        $this->isAddressDataValid($order);
    }

    /**
     * Check if torod integration credentials not exists or empty to trhow new exceptions.
     *
     * @exception CredentialsNotFound
     */
    private function _checkIntegrationCredentialsExists() : void
    {
        if(
            !config("shipping.aramex.AccountCountryCode") ||
            !config("shipping.aramex.AccountEntity") ||
            !config("shipping.aramex.AccountNumber") ||
            !config("shipping.aramex.AccountPin") ||
            !config("shipping.aramex.UserName") ||
            !config("shipping.aramex.Password")
        ) {
            $this->logger(self::LOG_CHANNEL, "ARAMEX:IntegrationCredentialsNotExists", [], true);
            throw new CredentialsNotFound();
        }
    }


    private function isAddressDataValid(Order $order) : bool
    {
        $warehouse = $this->orderVendorShipping->orderVendorWarehouses()->where('shipping_method_id' , $this->shipping_method_id)->first()->warehouse;
        $msg = '';

        if (empty($order->transaction->client)) $msg = "Customer not exists";
        else if (!$order->transaction->city) $msg = "city not exists";
        // else if (!$transaction->addresses->description) $msg = "Address not exists";
        else if (!$order->transaction->client->name) $msg = "customer miss  name";
        // else if (!$transaction->addresses->last_name) $msg = "Address miss the last name";
        else if (!$order->transaction->client->phone) $msg = "customer miss  phone";
        // else if (!$transaction->addresses->city) $msg = "Address city not exists";
        // else if (!$transaction->addresses->city->spl_id) $msg = "Address city spl id not exists";
        // else if (!$transaction->addresses->country) $msg = "Address country not exists";
        // else if (!$transaction->addresses->country->spl_id) $msg = "Address country spl id not exists";
        // else if (!$warehouse) $msg = "Address country warehouse not exists";
        else if (!$warehouse) $msg = "warehouse not exists";


//        dd($msg);
        if(!empty($msg)) {
            $this->logger(self::LOG_CHANNEL, "SPL:_checkShippingAddressDataExists", [
                "first_name" => $order->customer_name,
                "customer_email" => "info@me.com" , 
                "shpping_phone" =>  $order->transaction->client->phone ?? '' ,
                "shipping_city" =>  $order->transaction->city->name,
            ], true);
            throw new AddressComponentNotFound($msg);
        }

        return true;
    }

    /**
     * Check if transaction address not exists or empty to trhow new exceptions.
     *
     * @exception AddressComponentNotFound
     */
//    private function _checkAramexShippingAddressDataExists(Transaction $transaction) : void
//    {
//
//        if(
//            !$transaction->addresses->exists() ||
//            !$transaction->addresses->first_name ||
//            !$transaction->addresses->last_name ||
//            !$transaction->customer->exists() ||
//            !$transaction->addresses->phone ||
//            !$transaction->addresses->city->exists() ||
//            !$transaction->addresses->description
//        ) {
//            $this->logger(self::LOG_CHANNEL, "Aramex:_checkShippingAddressDataExists", [
//                "is_address_exists" => $transaction->addresses->exists() ? $transaction->addresses->exists() : null,
//                "first_name" => $transaction->addresses->first_name ? $transaction->addresses->first_name : null,
//                "last_name" => $transaction->addresses->last_name ? $transaction->addresses->last_name : null,
//                "is_customer_exists" => $transaction->customer->exists() ? $transaction->customer->exists() : null,
//                "customer_email" => $transaction->customer->email ? $transaction->customer->email : $transaction->customer->id . config("shipping.bezz.default_customer_email"),
//                "shpping_phone" => $transaction->addresses->phone ? $transaction->addresses->phone : null,
//                "shipping_city" => $transaction->addresses->city->exists() ? $transaction->addresses->city->exists() : null,
//                "address_description" => $transaction->addresses->description ? $transaction->addresses->description : null,
//                "country" => $transaction->addresses->country ? $transaction->addresses->country : null,
//                "warehouseCountry" => $transaction->addresses->country->warehouseCountry ? $transaction->addresses->country->warehouseCountry : null,
//                "warehouse" => $transaction->addresses->country->warehouseCountry->warehouse ? $transaction->addresses->country->warehouseCountry->warehouse : null
//            ], true);
//            throw new AddressComponentNotFound("Address not valid for aramex integration");
//        }
//    }
//
//    /**
//     * Check if warehouse exists and assossiated to country.
//     */
//    private function checkWarehouseComponentExists(Transaction $transaction) : bool
//    {
//        if(
//            !$transaction->addresses->country ||
//            !$transaction->addresses->country->warehouseCountry ||
//            !$transaction->addresses->country->warehouseCountry->warehouse
//        ) {
//            $this->logger(self::LOG_CHANNEL, "BEZZ:checkWarehouseComponentExists", [
//                "country" => $transaction->addresses->country ? $transaction->addresses->country : null,
//                "warehouseCountry" => $transaction->addresses->country->warehouseCountry ? $transaction->addresses->country->warehouseCountry : null,
//                "warehouse" => $transaction->addresses->country->warehouseCountry->warehouse ? $transaction->addresses->country->warehouseCountry->warehouse : null
//            ], true);
//            throw new WarehouseComponentNotFound();
//        }
//
//        return true;
//    }
//
//
//    /**
//     * Check if total Transaction amount not exists or empty to trhow new exceptions.
//     *
//     * @exception TransactionTotalAmountIsNull
//     */
//    private function _checkTotalTransactionAmountExists(Transaction $transaction) : void
//    {
//        if($transaction->total <= 0) {
//            $this->logger(self::LOG_CHANNEL, "ARAMEX:CheckTotalTransactionAmountExists", ["total_transaction" => $transaction->total], true);
//            throw new TransactionTotalAmountIsNull();
//        }
//    }
//





}
