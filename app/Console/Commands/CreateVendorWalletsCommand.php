<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VendorWallet;
use App\Models\Vendor;

class CreateVendorWalletsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CreateVendorWalletsCommand';

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
        $vendors_ids = Vendor::whereDoesntHave('wallet')->pluck('id')->toArray();
        foreach ($vendors_ids as $key => $vendor_id) {
            VendorWallet::create(['vendor_id' => $vendor_id, 'balance' => 0]);
        }
    }
}
