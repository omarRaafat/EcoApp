<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderLog>
 */
class OrderLogFactory extends Factory
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
            'order_id'=>Order::inRandomOrder()->first()->id,
            'old_status'=> fake()->randomElement($statuses),
            'new_status'=> fake()->randomElement($statuses)
        ];
    }
}
