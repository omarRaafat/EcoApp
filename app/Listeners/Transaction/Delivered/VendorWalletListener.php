<?php

namespace App\Listeners\Transaction\Delivered;

use App\Events\Transaction;
use App\Services\Wallet\VendorWalletService;
use Error;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class VendorWalletListener
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
     * @param Transaction\Delivered  $event
     * @return void
     */
    public function handle(Transaction\Delivered $event)
    {
        $order = $event->getOrder();
            try {
                if ($order?->vendor)
                    VendorWalletService::depositByOrder($order?->vendor, $order);
            } catch (Exception | Error $e) {
                Log::channel("transaction-events-errors")->error("Exception in Delivered/VendorWalletListener: ". $e->getMessage());
            }
    }
}
