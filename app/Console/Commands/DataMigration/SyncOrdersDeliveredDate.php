<?php

namespace App\Console\Commands\DataMigration;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Console\Command;

class SyncOrdersDeliveredDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:sync-delivered-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to add missed delivered_at column in orders table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Transaction::statuses([OrderStatus::COMPLETED, OrderStatus::SHIPPING_DONE])
        ->whereHas("orders", fn($o) => $o->whereNull("delivered_at"))
        ->lazy()
        ->each(function($transaction) {
            $orderIds = Order::transactionId($transaction->id)->whereNull("delivered_at")->select("id")->get()->implode("id", ",");
            echo "Working on Transaction: {$transaction->id}, Orders: ($orderIds), date: {$transaction->updated_at}".PHP_EOL;
            Order::transactionId($transaction->id)
                ->whereNull("delivered_at")
                ->update(["delivered_at" => $transaction->updated_at, 'status' => $transaction->status]);
        });
        return Command::SUCCESS;
    }
}
