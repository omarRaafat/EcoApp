<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseShippingTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'warehouse_id' => Warehouse::inRandomOrder()->first()->id,
            'shipping_type_id' => 1,
        ];
    }
}
