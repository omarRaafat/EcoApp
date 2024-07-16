<?php

namespace App\Jobs\CustomerSms;

use App\Enums\ClientMessageEnum;
use App\Models\ClientMessage;
use Error;
use Exception;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationCenterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TransactionRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Order $order
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $transaction = $this->transaction;
            $customer = $transaction->customer;

            $msg = "::var_client_name::،\n".
                "طلبك ::var_order_id:: بين ايديك، هني وعافية\n".
                "ولا تنسانا بتقييم الطلب\n".
                "::var_link_order::";

            $clientMessage = ClientMessage::messageFor(ClientMessageEnum::CompletedTransaction)->first();

            if ($clientMessage) $msg = $clientMessage->getTransMessage($customer->lang ?? "");

            $frontUrl = env("WEBSITE_BASE_URL"). "/user/rating-order/{$transaction->id}";

            $msg = Str::replace("::var_client_name::", $customer->name, $msg);
            $msg = Str::replace("::var_order_id::", $transaction->code, $msg);
            $msg = Str::replace("::var_link_order::", $frontUrl, $msg);

            (new NotificationCenterService)->toSms(['user' => $customer, 'message' => $msg,]);
        } catch (Exception | Error $e) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionRate: ". $e->getMessage());
        }
    }
}
