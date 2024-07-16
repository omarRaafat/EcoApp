<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseCityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'city_id'       => City::inRandomOrder()->first()->id,
            'warehouse_id'  => Warehouse::inRandomOrder()->first()->id,
        ];
    }
}
