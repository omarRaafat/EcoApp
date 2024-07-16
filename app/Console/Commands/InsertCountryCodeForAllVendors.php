<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Console\Command;

class InsertCountryCodeForAllVendors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendors:seed-country-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Witch Vendor phone number without country code than append it.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vendorUsers = User::whereIn("type", [UserTypes::VENDOR, UserTypes::SUBVENDOR])->get();
        
        $withCode = [];
        $withoutCode = [];

        foreach($vendorUsers as $vendorUser) {
            if(!str_contains($vendorUser->phone, "+966")) {
                $phoneWithCode = "+966" . $vendorUser->phone;
                $vendorUser->update(["phone" => $phoneWithCode]);
            }
        }

        return Command::SUCCESS;
    }
}
