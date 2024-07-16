<?php

namespace App\Listeners\Transaction\Cancelled;

use App\Events\Transaction;
use App\Jobs\CustomerSms\TransactionCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CustomerListener
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
     * @param Transaction\Cancelled $event $event
     * @return void
     */
    public function handle(Transaction\Cancelled $event)
    {
        dispatch(new TransactionCanceled($event->getTransaction()))->delay(5)->onQueue("customer-sms");
    }
}
