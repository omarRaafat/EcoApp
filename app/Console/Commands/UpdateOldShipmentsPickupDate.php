<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderStatusLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateOldShipmentsPickupDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:oldShipmentsPickupDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all the old shipments pickup dates depend on first status pickup date from order_status_logs table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Begin a transaction
        DB::beginTransaction();

        try {
            // Retrieve the earliest OrderStatusLogs for each order where the status is "PickedUp"
            $earliest_logs = OrderStatusLog::where('status', 'PickedUp')
            ->groupBy('order_id')
            ->selectRaw('MIN(id) as id, order_id, created_at')
            ->with('order') // Eager load orders
            ->get();

            // Initialize a variable to keep track of the number of orders updated
            $updatedOrdersCount = 0;

            // Array to store updated order IDs
            $updatedOrderIds = [];

            // Iterate through each log and update orders if pickup_at is null
            foreach ($earliest_logs as $log) {
                if ($log->order) {
                    if ($log->order->pickup_at === null) {
                        Order::withoutEvents(function () use ($log) {
                            $log->order->update(['pickup_at' => $log->created_at]);
                        });

                        $updatedOrdersCount++;
                        $updatedOrderIds[] = $log->order->id;
                    }
                } else {
                    // Log when $log->order is null
                    Log::info('Order is null for log ID: ' . $log->id);
                }
            }

            DB::commit();

            if($updatedOrdersCount > 0){
                // Log the IDs of the orders that were updated
                Log::info('Updated orders: ' . implode(', ', $updatedOrderIds));
            }

            $this->info($updatedOrdersCount . ' orders pickup_at column updated successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
