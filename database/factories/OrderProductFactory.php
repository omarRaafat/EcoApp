<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Order;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $order=Order::inRandomOrder()->first();
        return [
            'order_id'=>$order->id,
            'product_id'=>Product::inRandomOrder()->first()->id,
            'total'=>$order->total,
            'quantity'=>rand(10,100),
            'unit_price'=>rand(10,50),
        ];
    }
}
