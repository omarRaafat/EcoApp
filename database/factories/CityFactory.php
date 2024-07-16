<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ['ar'=>fake("ar_EG")->unique()->city(),'en'=>fake("ar_EG")->unique()->city(),],
            'area_id' => Area::inRandomOrder()->first()->id,
        ];
    }
}
