<?php

namespace Database\Seeders;

use App\Enums\VendorWallet;
use App\Models\Vendor;
use App\Models\VendorWalletTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::orderBy('id', 'desc')->limit(3)->get()->each(function ($v) {
            $wallet = $v->wallet;
            if (!$wallet) {
                $wallet = $v->wallet()->create();
            }
            $transactions = collect([]);
            $inAmt = $outAmt = 0;
            for($i = 0; $i < 3; $i++) {
                $amt = fake()->numerify("##.#");
                $transactions->push([
                    'wallet_id' => $wallet->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'amount' => $amt,
                    'operation_type' => VendorWallet::OUT
                ]);
                $outAmt += $amt;
            }
            for($i = 0; $i < 3; $i++) {
                $amt = fake()->numerify("###.#");
                $transactions->push([
                    'wallet_id' => $wallet->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'amount' => $amt,
                    'operation_type' => VendorWallet::IN
                ]);
                $inAmt += $amt;
            }
            VendorWalletTransaction::insert($transactions->toArray());
            $wallet->update(['balance' => $inAmt - $outAmt]);
        });
    }
}
