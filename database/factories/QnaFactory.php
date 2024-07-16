<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qna>
 */
class QnaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "question" => [
                "ar" => fake("ar_EG")->sentence(6),
                "en" => fake()->sentence(6) 
            ],
            "answer" => [
                "ar" => fake("ar_EG")->sentence(6),
                "en" => fake()->sentence(6) 
            ],
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
