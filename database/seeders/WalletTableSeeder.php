<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\WalletTransactionHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('wallets')->truncate();
        $customersCount = User::where('type','customer')->count();
        for($counter = 1; $counter <= $customersCount; $counter++) {
            Wallet::factory()->create();
        }
        Schema::enableForeignKeyConstraints();
    }
}
