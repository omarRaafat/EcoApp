<?php

namespace App\Jobs\CustomerSms;

use App\Enums\OrderStatus;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\ClientMessage;
use Illuminate\Bus\Queueable;
use App\Enums\ClientMessageEnum;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationCenterService;
use Error;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class TransactionCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Transaction $transaction
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $customer = $this->transaction->customer;
            $msg = "شكرا يا ::var_client_name::،\n" .
                "تم إستلام طلبك رقم ::var_order_id::\n" .
                "بقيمة ::var_order_amount:: ر.س.";

            $invoice_number = implode(', ', $this->transaction->orders()->pluck('code')->toArray());

            $clientMessage = ClientMessage::messageFor(ClientMessageEnum::CreatedTransaction)->first();

            if ($clientMessage) $msg = $clientMessage->getTransMessage($customer->lang ?? "");

            $msg = str_replace("::var_client_name::", $customer->name, $msg);
            $msg = str_replace("::var_order_id::", $this->transaction->code, $msg);
            $msg = str_replace("::var_order_amount::", $this->transaction->total, $msg);
            $msg = str_replace("::var_order_invoice_no::", $invoice_number, $msg);

            (new NotificationCenterService)->toSms(['user' => $customer, 'message' => $msg]);

        } catch (Exception|Error $e) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionCreated: " . $e->getMessage());
        }
    }
}
