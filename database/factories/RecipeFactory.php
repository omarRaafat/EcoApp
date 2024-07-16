<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qna>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => [
                "ar" => fake("ar_EG")->sentence(6),
                "en" => fake()->sentence(6) 
            ],
            "body" => [
                "ar" => fake("ar_EG")->text(500),
                "en" => fake()->text(500) 
            ],
            "short_desc" => [
                "ar" => fake("ar_EG")->name(15),
                "en" => fake()->name(15) 
            ],
            'most_visited'=>0,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
