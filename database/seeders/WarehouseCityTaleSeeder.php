<?php

namespace Database\Seeders;

use App\Models\WarehouseCity;
use Illuminate\Database\Seeder;

class WarehouseCityTaleSeeder extends Seeder
{
    public function run():void
    {
        WarehouseCity::factory(10)->create();

    }
}
