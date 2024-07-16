<?php

namespace App\Integrations\Shipping\Integrations\Torod;

use App\Models\Warehouse;
use App\Models\Transaction;
use App\Enums\WarehouseIntegrationKeys;
use App\Exceptions\Integrations\Shipping\CredentialsNotFound;
use App\Exceptions\Integrations\Shipping\Torod\CourierIdCannotBeNull;
use App\Exceptions\Integrations\Shipping\AddressComponentNotFound;
use App\Exceptions\Integrations\Shipping\TransactionTotalAmountIsNull;
use App\Exceptions\Integrations\Shipping\Torod\WarehouseCannotBeNull;
use App\Exceptions\Integrations\Shipping\Torod\TransactionTotalWeightCannotBeNull;

class DataValidationBeforApiCalls
{
    /**
     * Check data validation before making any API call to torod integration API
     * to avoid any failure thought the shipment operation.
     */
    public function __invoke(Transaction $transaction) : void
    {
        $this->_checkIntegrationCredentialsExists();
        $this->_checkTorodShippingAddressDataExists($transaction);
        $this->_checkTotalTransactionAmountExists($transaction);
        $this->_checkTotalTransactionWeightExists($transaction);
        // $this->_checkTorodCourierIdExists($transaction);
    }

    /**
     * Check if torod integration credentials not exists or empty to trhow new exceptions.
     *
     * @exception CredentialsNotFound
     */
    private function _checkIntegrationCredentialsExists() : void
    {
        if(
            !config("shipping.torod.stage_url") || // change url in production to "shipping.torod.production_url"
            !config("shipping.torod.client_id") ||
            !config("shipping.torod.client_secret")
        ) {
            throw new CredentialsNotFound();
        }
    }

    /**
     * Check if transaction address not exists or empty to trhow new exceptions.
     *
     * @exception AddressComponentNotFound
     */
    private function _checkTorodShippingAddressDataExists(Transaction $transaction) : void
    {
        if(
            $transaction->addresses->isEmpty ||
            !$transaction->addresses->first_name ||
            !$transaction->addresses->last_name ||
            $transaction->customer->isEmpty ||
            !$transaction->customer->email ||
            !$transaction->addresses->phone ||
            $transaction->addresses->city->isEmpty ||
            !$transaction->addresses->description ||
            !$transaction->addresses->city->torod_city_id
        ) {
            throw new AddressComponentNotFound("Address not valid for Torod integration");
        }
    }

    /**
     * Check if total Transaction amount not exists or empty to trhow new exceptions.
     *
     * @exception TransactionTotalAmountIsNull
     */
    private function _checkTotalTransactionAmountExists(Transaction $transaction) : void
    {
        if($transaction->total <= 0) {
            throw new TransactionTotalAmountIsNull();
        }
    }

    /**
     * Check if total transaction weight not exists or empty to trhow new exceptions.
     *
     * @exception TransactionTotalWeightCannotBeNull
     */
    private function _checkTotalTransactionWeightExists(Transaction $transaction) : void
    {
        if(
            $transaction->products->isEmpty() ||
            $transaction->products->pluck("weight_with_kilo")->sum() <= 0
        ) {
            throw new TransactionTotalWeightCannotBeNull();
        }
    }

    /**
     * Check if Warehouse not exists or empty to trhow new exceptions.
     *
     * @exception WarehouseCannotBeNull
     */
    private function _checkWarehouseExists(Transaction $transaction) : void
    {
        $warehouse = Warehouse::where("integration_key", WarehouseIntegrationKeys::NATIONAL_WAREHOUSE)->first();

        if(!$warehouse || !$warehouse->torod_warehouse_name) {
            throw new WarehouseCannotBeNull();
        }
    }

    /**
     * Check if Courier Id Exists not exists or empty to trhow new exceptions.
     *
     * @exception CourierIdCannotBeNull
     */
    private function _checkTorodCourierIdExists(Transaction $transaction) : void
    {
        $courier_partner_id = $transaction->addresses->city->domesticZones->torodCompany->torod_courier_id;
        if(
            $transaction->addresses->isEmpty ||
            $transaction->addresses->city->isEmpty ||
            !$transaction->addresses->city->is_active ||
            $transaction->addresses->city->torod_city_id
            // TODO: need to be refactored according to new business for domestic zone
            // $transaction->addresses->city->domesticZones->isEmpty ||
            // $transaction->addresses->city->domesticZones->torodCompany->isEmpty ||
            // !$transaction->addresses->city->domesticZones->torodCompany->torod_courier_id
        ) {
            throw new CourierIdCannotBeNull();
        }

    }
}
