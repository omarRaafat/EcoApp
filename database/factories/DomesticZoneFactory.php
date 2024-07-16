<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DomesticZone>
 */
class DomesticZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => [
                'ar' => fake("ar_EG")->text(5) ." ". fake("ar_EG")->text(5),
                'en' => fake("en_EG")->text(5) ." ". fake("en_EG")->text(5),
            ],
        ];
    }
}
