<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use App\Jobs\CheckOrderAramexStatusJob;

class UpdateOrdersAramexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateOrdersAramexCommand';

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
        $index = 0;
        $orders = Order::whereHas('orderShip')->with('orderShip')->whereIn('status',['processing','PickedUp','in_shipping'])
            ->where('delivery_type','like','أرامكس')->chunk(8, function ($orders) use(&$index) {
                foreach ($orders as $order) {
                    $job = (new CheckOrderAramexStatusJob($order))->onQueue("transactions-queue")->delay(Carbon::now()->addMinutes($index));
                    dispatch($job);
                }

                $index++;
            });
    }
}
