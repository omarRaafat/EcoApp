<?php

namespace App\Listeners\Warehouse;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Warehouse\CreateVendorWarehouseRequest;
use App\Integrations\Shipping\Integrations\Bezz\StorageRequest;

class BeezSotrageRequestListener
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
     * @param  \App\Events\Warehouse\CreateVendorWarehouseRequest  $event
     * @return void
     */
    public function handle(CreateVendorWarehouseRequest $event)
    {
        /**
         * TODO: Create Warehouse Adabter
         */
        (new StorageRequest)($event->getVendorWarehouseRequest());
    }
}
