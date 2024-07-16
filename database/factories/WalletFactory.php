<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $wallet_customer_ids = Wallet::pluck('customer_id')->toArray();
        $admins = User::where("type", "admin")->pluck('id')->toArray();
        
        return [
            "customer_id" => User::where('type','customer')->whereNotIn('id',$wallet_customer_ids)->inRandomOrder()->first()->id,
            "admin_id" => User::where("type", "admin")->inRandomOrder()->first()->id,
            "is_active" => rand(0,1),
            "amount" => rand(2,99999),
            "reason" => fake()->sentence()
        ];
    }
}
