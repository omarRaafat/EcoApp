<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>['ar'=>fake("ar_EG")->city(),'en'=>fake("en_EG")->city()],
            'country_id' => Country::inRandomOrder()->first()->id,
        ];
    }
}
