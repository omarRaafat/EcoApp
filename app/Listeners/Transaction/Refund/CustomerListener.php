<?php

namespace App\Listeners\Transaction\Refund;

use App\Events\Transaction;
use App\Jobs\CustomerSms\TransactionCanceled;
use App\Jobs\CustomerSms\TransactionRefund;
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
     * @param Transaction\Refund $event $event
     * @return void
     */
    public function handle(Transaction\Refund $event)
    {
        dispatch(new TransactionRefund($event->getTransaction()))->delay(5)->onQueue("customer-sms");
    }
}
