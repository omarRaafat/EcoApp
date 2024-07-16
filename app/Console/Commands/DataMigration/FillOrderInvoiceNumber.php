<?php

namespace App\Console\Commands\DataMigration;

use App\Models\Order;
use Illuminate\Console\Command;

class FillOrderInvoiceNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:fill-invoice-number';

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
        Order::whereNull("invoice_number")->lazy()->each(function($order) {
            $order->invoice_number = rand(100000000000, 999999999999);
            $order->save();
        });
        return Command::SUCCESS;
    }
}
