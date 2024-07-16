<?php

namespace App\Listeners\Transaction\Refund;

use App\Events\Transaction;
use App\Jobs\WebEngage\OrderRefund;
use Error;
use Exception;
use Illuminate\Support\Facades\Log;

class WebEngageListener
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
     * @param  Transaction\Refund  $event
     * @return void
     */
    public function handle(Transaction\Refund $event)
    {
        try {
            dispatch(new OrderRefund($event->getTransaction()))->delay(5)->onQueue("transactions-queue");
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in Created/WebEngageListener: ". $e->getMessage());
        }
    }
}
