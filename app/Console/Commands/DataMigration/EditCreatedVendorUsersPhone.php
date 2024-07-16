<?php

namespace App\Console\Commands\DataMigration;

use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EditCreatedVendorUsersPhone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:edit-phone-country-code';

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
        User::whereIn('type', [UserTypes::SUBVENDOR, UserTypes::VENDOR])->get()->each(function($vendorUser) {
            $msg = "Working on vendor user: $vendorUser->id, phone: $vendorUser->phone";
            echo $msg;
            Log::info($msg);
            if (!Str::startsWith($vendorUser->phone, "+966") && Str::startsWith($vendorUser->phone, "05")) {
                $vendorUser->update(['phone' => "+966" . $vendorUser->phone]);
                echo " ,working on update phone";
                Log::info("working on update phone");
            }
            echo PHP_EOL;
        });
        return Command::SUCCESS;
    }
}
