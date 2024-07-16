<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearSeederDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:dummy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear dummy data from seeder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        DB::table('cart_vendor_shipping_warehouses')->delete();
        DB::table('cart_vendor_shippings')->delete();
        DB::table('order_vendor_shippings')->delete();
        DB::table('order_vendor_shipping_warehouses')->delete();
        DB::table('order_products')->delete();
        DB::table('carts')->delete();
        DB::table('warehouses')->delete();
        DB::table('vendors')->delete();
        DB::table('vendor_wallets')->delete();
        DB::table('areas')->delete();
        DB::table('cities')->delete();
        DB::table('user_vendor_rates')->delete();
        DB::table('orders')->delete();

        return Command::SUCCESS;
    }
}
