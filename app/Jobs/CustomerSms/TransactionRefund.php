<?php

namespace App\Jobs\CustomerSms;

use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\ClientMessage;
use Illuminate\Bus\Queueable;
use App\Enums\ClientMessageEnum;
use App\Services\NotificationCenterService;
use Error;
use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class TransactionRefund implements ShouldQueue
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

            $msg = "::var_client_name::،\n".
                "تم استرجاع طلبك رقم ::var_order_id::\n";

            $clientMessage = ClientMessage::messageFor(ClientMessageEnum::RefundTransaction)->first();

            if ($clientMessage) $msg = $clientMessage->getTransMessage($customer->lang ?? "");

            $msg = Str::replace("::var_client_name::", $customer->name, $msg);
            $msg = Str::replace("::var_order_id::", $this->transaction->code, $msg);

            (new NotificationCenterService)->toSms(['user' => $customer, 'message' => $msg]);
        } catch (Exception | Error $e) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionRefund: ". $e->getMessage());
        }
    }
}
