<?php

namespace App\Listeners\Transaction\Completed;

use App\Events\Transaction;
use App\Jobs\CustomerSms\TransactionInvoice;
use App\Jobs\CustomerSms\TransactionRate;
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
     * @param Transaction\Completed $event
     * @return void
     */
    public function handle(Transaction\Completed $event)
    {
        $transaction = $event->getTransaction();
        dispatch(new TransactionRate($transaction))->delay(5)->onQueue("customer-sms");
        dispatch(new TransactionInvoice($transaction))->delay(5)->onQueue("customer-sms");
    }
}
