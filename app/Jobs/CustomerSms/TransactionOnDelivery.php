<?php

namespace App\Jobs\CustomerSms;

use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\ClientMessage;
use Illuminate\Bus\Queueable;
use App\Enums\ClientMessageEnum;
use App\Models\Order;
use App\Services\NotificationCenterService;
use App\Services\SendSms;
use Error;
use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class TransactionOnDelivery implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Order $order
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $customer = $this->order->transaction->client;

            $msg = "::var_client_name::،\n جاري توصيل طلبك رقم ::var_order_id::";

            $clientMessage = ClientMessage::messageFor(ClientMessageEnum::OnDeliveryTransaction)->first();

            if ($clientMessage) $msg = $clientMessage->getTransMessage("");

            $msg = Str::replace("::var_client_name::", $customer->name, $msg);
            $msg = Str::replace("::var_order_id::", $this->order->code, $msg);
            SendSms::toSms($customer->phone , $msg);
        } catch (Exception | Error $e) {
            Log::channel("customer-sms-errors")->error("Exception in TransactionOnDelivery: ". $e->getMessage());
        }
    }
}
