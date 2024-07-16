<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qna>
 */
class StaticContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types=['about','policy','usage'];
        return [
            "title" => [
                "ar" => fake("ar_EG")->sentence(6),
                "en" => fake()->sentence(6) 
            ],
            "paragraph" => [
                "ar" => fake("ar_EG")->sentence(200),
                "en" => fake()->sentence(200) 
            ],
            "type" => $types[array_rand($types,1)],
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
