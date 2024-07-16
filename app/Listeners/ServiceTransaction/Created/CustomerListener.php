<?php

namespace App\Listeners\Transaction\Created;

use App\Events\Transaction;
use App\Jobs\CustomerSms\TransactionCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  Transaction\Created  $event
     * @return void
     */
    public function handle(Transaction\Created $event)
    {
        dispatch(new TransactionCreated($event->getTransaction()))->delay(5)->onQueue("customer-sms");
    }
}
