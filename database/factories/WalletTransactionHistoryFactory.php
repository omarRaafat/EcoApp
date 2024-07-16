<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletTransactionHistory>
 */
class WalletTransactionHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $wallet = Wallet::inRandomOrder()->first();

        return [
            "customer_id" => $wallet->customer_id,
            "wallet_id" => $wallet->id,
            "type" => rand(0,1),
            "amount" => $wallet->amount / 6,
            "is_opening_balance" => false,
            "transaction_type" => 1,
            "user_id" => User::where("type", "admin")->inRandomOrder()->first()->id
        ];
    }
}
