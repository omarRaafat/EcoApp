<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionLog>
 */
class TransactionLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statuses=['registered','shipping_done','in_delivery','completed','canceled','refund'];
        return [
            'transaction_id'=>Transaction::inRandomOrder()->first()->id,
            'old_status'=> fake()->randomElement($statuses),
            'new_status'=> fake()->randomElement($statuses)
        ];
    }
}
