<?php

namespace App\Jobs\CustomerSms;

use App\Models\User;
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

class DepositBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private User $customer,
        private float $amount
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $msg = "::var_client_name::،\n".
                "تم إضافة مبلغ: ::var_deposited_balance:: لمحفظتك\n";

            $clientMessage = ClientMessage::messageFor(ClientMessageEnum::DepositBalance)->first();

            if ($clientMessage) $msg = $clientMessage->getTransMessage($this->customer->lang ?? "");

            $msg = Str::replace("::var_client_name::", $this->customer->name, $msg);
            $msg = Str::replace("::var_deposited_balance::", $this->amount, $msg);

            (new NotificationCenterService)->toSms(['user' => $this->customer, 'message' => $msg]);
        } catch (Exception | Error $e) {
            Log::channel("customer-sms-errors")->error("Exception in DepositBalance: ". $e->getMessage());
        }
    }
}
