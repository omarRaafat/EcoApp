<?php
namespace App\Integrations\Shipping\Integrations\Bezz;

use App\Models\Transaction;
use App\Integrations\Shipping\Integrations\Traits\Logger;
use App\Exceptions\Integrations\Shipping\CredentialsNotFound;
use App\Exceptions\Integrations\Shipping\AddressComponentNotFound;
use App\Exceptions\Integrations\Shipping\WarehouseComponentNotFound;
use App\Exceptions\Integrations\Shipping\TransactionTotalAmountIsNull;

class DataValidationBeforApiCalls
{
    use Logger;

    /**
     * Log Channel...
     */
    const LOG_CHANNEL = "bezz-shipping";

    /**
     * Check data validation before making any API call to torod integration API
     * to avoid any failure thou    ght the shipment operation.
     */
    public function __invoke(Transaction $transaction) : void
    {
        $this->_checkIntegrationCredentialsExists();
        $this->_checkBezzShippingAddressDataExists($transaction);
        $this->_checkTotalTransactionAmountExists($transaction);

    }

    /**
     * Check if torod integration credentials not exists or empty to trhow new exceptions.
     *
     * @exception CredentialsNotFound
     */
    private function _checkIntegrationCredentialsExists() : void
    {
        if(
            !config("shipping.bezz.acccount_number") || // change url in production to "shipping.torod.production_url"
            !config("shipping.bezz.api_key") ||
            !config("shipping.bezz.base_url")
        ) {
            $this->logger(self::LOG_CHANNEL, "BEZZ:IntegrationCredentialsNotExists", [], true);
            throw new CredentialsNotFound();
        }
    }


    /**
     * Check if transaction address not exists or empty to trhow new exceptions.
     *
     * @exception AddressComponentNotFound
     */
    private function _checkBezzShippingAddressDataExists(Transaction $transaction) : void
    {

        if(

            !$transaction->addresses->exists() ||
            !$transaction->addresses->first_name ||
            !$transaction->addresses->last_name ||
            !$transaction->customer->exists() ||
            !$transaction->addresses->phone ||
            !$transaction->addresses->city->exists() ||
            !$transaction->addresses->description
        ) {
            $this->logger(self::LOG_CHANNEL, "BEZZ:_checkShippingAddressDataExists", [
                "is_address_exists" => $transaction->addresses->exists() ? $transaction->addresses->exists() : null,
                "first_name" => $transaction->addresses->first_name ? $transaction->addresses->first_name : null,
                "last_name" => $transaction->addresses->last_name ? $transaction->addresses->last_name : null,
                "is_customer_exists" => $transaction->customer->exists() ? $transaction->customer->exists() : null,
                "customer_email" => $transaction->customer->email ? $transaction->customer->email : $transaction->customer->id . config("shipping.bezz.default_customer_email"),
                "shpping_phone" => $transaction->addresses->phone ? $transaction->addresses->phone : null,
                "shipping_city" => $transaction->addresses->city->exists() ? $transaction->addresses->city->exists() : null,
                "address_description" => $transaction->addresses->description ? $transaction->addresses->description : null,
                "country" => $transaction->addresses->country ? $transaction->addresses->country : null,
                "warehouseCountry" => $transaction->addresses->country->warehouseCountry ? $transaction->addresses->country->warehouseCountry : null,
                "warehouse" => $transaction->addresses->country->warehouseCountry->warehouse ? $transaction->addresses->country->warehouseCountry->warehouse : null
            ], true);
            throw new AddressComponentNotFound("Address not valid for Bezz integration");
        }
    }

    /**
     * Check if warehouse exists and assossiated to country.
     */
    private function checkWarehouseComponentExists(Transaction $transaction) : bool
    {
        if(
            !$transaction->addresses->country ||
            !$transaction->addresses->country->warehouseCountry ||
            !$transaction->addresses->country->warehouseCountry->warehouse
        ) {
            $this->logger(self::LOG_CHANNEL, "BEZZ:checkWarehouseComponentExists", [
                "country" => $transaction->addresses->country ? $transaction->addresses->country : null,
                "warehouseCountry" => $transaction->addresses->country->warehouseCountry ? $transaction->addresses->country->warehouseCountry : null,
                "warehouse" => $transaction->addresses->country->warehouseCountry->warehouse ? $transaction->addresses->country->warehouseCountry->warehouse : null
            ], true);
            throw new WarehouseComponentNotFound();
        }

        return true;
    }


    /**
     * Check if total Transaction amount not exists or empty to trhow new exceptions.
     *
     * @exception TransactionTotalAmountIsNull
     */
    private function _checkTotalTransactionAmountExists(Transaction $transaction) : void
    {
        if($transaction->total <= 0) {
            $this->logger(self::LOG_CHANNEL, "BEZZ:CheckTotalTransactionAmountExists", ["total_transaction" => $transaction->total], true);
            throw new TransactionTotalAmountIsNull();
        }
    }






}
