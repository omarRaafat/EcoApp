<?php

namespace App\Listeners\Transaction\Delivered;

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
     * @param Transaction\Delivered $event
     * @return void
     */
    public function handle(Transaction\Delivered $event)
    {
        $order = $event->getOrder();
        // dispatch(new TransactionRate($order))->delay(5)->onQueue("customer-sms");
        dispatch(new TransactionInvoice($order))->delay(5)->onQueue("customer-sms");
    }
}
