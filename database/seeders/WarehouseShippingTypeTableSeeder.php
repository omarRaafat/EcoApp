<?php

namespace Database\Seeders;

use App\Models\WarehouseShippingType;
use Illuminate\Database\Seeder;

class WarehouseShippingTypeTableSeeder extends Seeder
{
    public function run(): void
    {
        WarehouseShippingType::factory(10)->create();
    }
}
