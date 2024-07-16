<?php

namespace App\Listeners\Transaction\Refund;

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
     * @param Transaction\Refund  $event
     * @return void
     */
    public function handle(Transaction\Refund $event)
    {
        $event->getTransaction()->orders
        ->each(function ($order) {
            try {
                if ($order?->vendor)
                    VendorWalletService::withdrawByOrder($order?->vendor, $order);
            } catch (Exception | Error $e) {
                Log::channel("transaction-events-errors")->error("Exception in Refund/VendorWalletListener: ". $e->getMessage());
            }
        });
    }
}
