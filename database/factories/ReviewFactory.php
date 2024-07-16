<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'comment'=>$this->faker->sentence,
            'rate'=>rand(1,5),
            'user_id'=>\App\Models\User::where('type','customer')->inRandomOrder()->first()->id,
            'product_id'=>\App\Models\Product::inRandomOrder()->first()->id
        ];
    }
}
