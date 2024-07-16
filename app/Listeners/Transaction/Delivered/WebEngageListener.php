<?php

namespace App\Listeners\Transaction\Delivered;

use App\Events\Transaction;
use App\Jobs\WebEngage\OrderDelivered;
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
     * @param  Transaction\Delivered  $event
     * @return void
     */
    public function handle(Transaction\Delivered $event)
    {
        try {
            dispatch(new OrderDelivered($event->getTransaction()))->delay(5)->onQueue("transactions-queue");
        } catch (Exception | Error $e) {
            Log::channel("transaction-events-errors")->error("Exception in Created/WebEngageListener: ". $e->getMessage());
        }
    }
}
