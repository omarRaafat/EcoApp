<?php

namespace App\Listeners\Warehouse;

use App\Models\TransactionWarning;
use App\Models\WarehouseShippingRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Warehouse\CreateBezzShippingApiCall;
use App\Integrations\Shipping\Integrations\Bezz\Bezz;
use App\Integrations\Shipping\Integrations\Bezz\StorageRequest;

class CreateBezzShippingApiCallListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Warehouse\CreateBezzShippingApiCall  $event
     * @return void
     */
    public function handle(CreateBezzShippingApiCall $event)
    {
        $address = $event->getTransaction()->addresses;

        if(!$address) {
            TransactionWarning::create([
                'message' => "No address assossiated to this transaction.",
                'reference_type' => 'CreateBezzShippingApiCallListener',
                'transaction_id' => $event->getTransaction()->id,
            ]);

            return;
        }

        if(!$address->country) {
            TransactionWarning::create([
                'message' => "No country assossiated to this transaction.",
                'reference_type' => 'CreateBezzShippingApiCallListener',
                'transaction_id' => $event->getTransaction()->id,
            ]);

            return;
        }

        if(!$address->country->warehouseCountry || !$address->country->warehouseCountry->warehouse) {
            TransactionWarning::create([
                'message' => "No WarehouseCountry of Warehouse assossiated to this transaction.",
                'reference_type' => 'CreateBezzShippingApiCallListener',
                'transaction_id' => $event->getTransaction()->id,
            ]);

            return;
        }

        $warehouse = $address->country->warehouseCountry->warehouse;

        $bezzShipment = new Bezz;

        $trackingNumber = $bezzShipment->shipmentApiCall($event->getTransaction());

        WarehouseShippingRequest::create([
            "reference_model" => get_class($event->getTransaction()),
            "reference_model_id" => $event->getTransaction()->id,
            "warehouse_id" => $warehouse->id,
            "tracking_id" => $trackingNumber
        ]);
    }
}
