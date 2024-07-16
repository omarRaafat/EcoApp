<?php

namespace App\Console\Commands\DataMigration\BezzTransactions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\TransactionLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncBezzDeliveryDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bezz:sync-delivery-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command for running 1 time (when need to sync delivery date from bezz sheet)\n".
        "sheet header: (tracking number, order number, delivery date)\n".
        "sheet must be beside this file (in  this path: app/Console/Commands/DataMigration/BezzTransactions/data.csv)";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (($handle = fopen(__DIR__. "/data.csv", "r")) !== FALSE) {
            $this->info("Start working on csv file");
            // ignore first line (header)
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== FALSE) {
                $orderNumber = $row[1];
                $deliveredDate = $row[2];

                if (!$deliveredDate) {
                    $this->info("Order number: $orderNumber missed delivered date");
                    continue;
                }

                $deliveredDate = Carbon::parse($deliveredDate);

                $transaction = Transaction::with([
                    "transactionStatusLogs",
                ])
                ->where("code", $orderNumber)->first();

                if (!$transaction) {
                    $this->info("Order number: $orderNumber missed at our system");
                    continue;
                }
                $infoMsg = "Transaction code: {$transaction->code}, status: {$transaction->status}";

                $deliveredLogs = $transaction->transactionStatusLogs->whereIn("new_status", [OrderStatus::COMPLETED, OrderStatus::SHIPPING_DONE]);
                $lastLog = $transaction->transactionStatusLogs->whereNotIn("new_status", [OrderStatus::COMPLETED, OrderStatus::SHIPPING_DONE])->last();

                if ($deliveredLogs->isNotEmpty()) {
                    DB::table("transaction_logs")
                        ->whereIn("id", $deliveredLogs->pluck("id")->toArray())
                        ->update(["created_at" => $deliveredDate->toDateTimeString(), "updated_at" => $deliveredDate->toDateTimeString()]);
                    $infoMsg .= ", logs updated (created_at & updated_at) columns";
                } else {
                    TransactionLog::insert([
                        'old_status' => $lastLog ? $lastLog->new_status : OrderStatus::REGISTERD,
                        'new_status' => OrderStatus::SHIPPING_DONE,
                        'transaction_id' => $transaction->id,
                        "created_at" => $deliveredDate->toDateTimeString(),
                        "updated_at" => $deliveredDate->toDateTimeString()
                    ]);
                    $infoMsg .= ", logs inserted";
                }

                Order::query()
                    ->transaction($transaction->id)
                    ->update(['status' => $transaction->status, 'delivered_at' => $deliveredDate->toDateTimeString()]);

                $this->info($infoMsg);
            }
            $this->info("Finished...");
            fclose($handle);
        } else {
            $this->info("Can`t open csv file");
        }
        return Command::SUCCESS;
    }
}
