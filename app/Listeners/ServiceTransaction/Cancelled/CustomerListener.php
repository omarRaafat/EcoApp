<?php

namespace App\Listeners\ServiceTransaction\Cancelled;

use App\Events\ServiceTransaction;
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

    public function handle(ServiceTransaction\Cancelled $event)
    {
        dispatch(new TransactionCanceled($event->getTransaction()))->delay(5)->onQueue("customer-sms");
    }
}
