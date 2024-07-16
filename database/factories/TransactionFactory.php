<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Currency;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $addresses = $user->addresses->pluck("id")->toArray();

        return [
            'customer_id'=> $user->id,
            'currency_id'=>Currency::inRandomOrder()->first(),
            'address_id' => (count($addresses) > 0) ? fake()->randomElement($addresses) : 1,
            'date'=>Carbon::now(),
            'status'=> fake()->randomElement(OrderStatus::getStatuses()),
            'total'=>150.50,
            'sub_total'=>130.50,
            'total_vat'=>10.00,
            // 'total_tax'=>10.00,
            'code'=>transactionCode(),
            'payment_method' => 1,
            'products_count' => rand(2,6)
        ];
    }
}
