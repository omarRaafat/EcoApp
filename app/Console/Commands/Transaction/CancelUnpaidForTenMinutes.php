<?php

namespace App\Console\Commands\Transaction;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethods;
use App\Models\Transaction;
use App\Events\Transaction as TransactionEvents;
use App\Jobs\WebEngage\PaymentFailure;
use App\Services\Payments\Urway\UrwayServices;
use Exception;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CancelUnpaidForTenMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:cancel-unpaid-for-ten-minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to cancel unpaid transaction with online payment method and created from ten minutes ago';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Transaction::createdTenMinutesAgo()
            ->whereIn('status',[OrderStatus::REGISTERD])
            ->payment(PaymentMethods::VISA)
            ->with("orders.vendor.wallet.transactions", "urwayTransaction")
            ->latest()->limit(25)->get()
            ->each(function($transaction) {
                $isPaid = false;
                try {
                    $isPaid = UrwayServices::transactionInquiry($transaction);
                } catch (Exception $e) {
                    $isPaid = false;
                }

                if ($isPaid) {
                    $transaction->status = OrderStatus::PAID;
                    $transaction->save();
                }else{
                    $transaction->update(['note' => "customer not paid!"]);
                }
            });
        return Command::SUCCESS;
    }
}
