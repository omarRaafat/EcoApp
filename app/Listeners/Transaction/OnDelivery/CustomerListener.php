<?php

namespace App\Listeners\Transaction\OnDelivery;

use App\Events\Transaction;
use App\Jobs\CustomerSms\TransactionOnDelivery;
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
     * @param Transaction\OnDelivery $event
     * @return void
     */
    public function handle(Transaction\OnDelivery $event)
    {
        dispatch(new TransactionOnDelivery($event->getOrder() , $event->getOrder()))->delay(5)->onQueue("customer-sms");
    }
}
