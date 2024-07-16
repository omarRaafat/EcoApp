<?php

namespace App\Listeners\Transaction\Cancelled;

use App\Events\Transaction;
use App\Jobs\WebEngage\OrderCanceled;
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
     * @param  Transaction\Cancelled  $event
     * @return void
     */
    public function handle(Transaction\Cancelled $event)
    {
        try {
            dispatch(new OrderCanceled($event->getTransaction()))->delay(5)->onQueue("transactions-queue");
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in Created/WebEngageListener: ". $e->getMessage());
        }
    }
}
