<?php

namespace App\Listeners\ServiceTransaction\Cancelled;

use App\Events\ServiceTransaction;
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

    public function handle(ServiceTransaction\Cancelled $event)
    {
        $event->getTransaction()->orderServices
        ->each(function ($order) {
            try {
                if ($order?->vendor)
                    VendorWalletService::withdrawByOrder($order?->vendor, $order);
            } catch (Exception | Error $e) {
                Log::channel("transaction-events-errors")->error("Exception in Cancelled/VendorWalletListener: ". $e->getMessage());
            }
        });
    }
}
