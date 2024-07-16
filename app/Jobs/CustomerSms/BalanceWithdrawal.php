<?php

namespace App\Jobs\CustomerSms;

use Error;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ClientMessage;
use Illuminate\Bus\Queueable;
use App\Enums\ClientMessageEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationCenterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class BalanceWithdrawal implements ShouldQueue
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
                "تم خصم مبلغ: ::var_withdrawal_balance:: من محفظتك\n";

            $clientMessage = ClientMessage::messageFor(ClientMessageEnum::BalanceWithdrawal)->first();

            if ($clientMessage) $msg = $clientMessage->getTransMessage($this->customer->lang ?? "");

            $msg = Str::replace("::var_client_name::", $this->customer->name, $msg);
            $msg = Str::replace("::var_withdrawal_balance::", $this->amount, $msg);

            (new NotificationCenterService)->toSms(['user' => $this->customer, 'message' => $msg]);
        } catch (Exception | Error $e) {
            Log::channel("customer-sms-errors")->error("Exception in BalanceWithdrawal: ". $e->getMessage());
        }
    }
}
