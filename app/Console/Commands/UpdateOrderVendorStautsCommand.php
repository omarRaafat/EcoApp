<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Enums\OrderStatus;
use App\Models\Transaction;
use App\Models\Order;

class UpdateOrderVendorStautsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateOrderVendorStautsCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::where('status',OrderStatus::CANCELED)->get();
        foreach ($orders as $key => $order) {
            $order->orderVendorShippings()->update(['status' => OrderStatus::CANCELED]);
        }

        return Command::SUCCESS;
    }
}
