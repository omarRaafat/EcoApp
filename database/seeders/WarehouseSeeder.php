<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Warehouse::factory(10)->make()->each(function ($warehouse) {
//            Warehouse::updateOrCreate(['integration_key' => $warehouse->integration_key], $warehouse->toArray());
//        });

        Warehouse::factory()->count(10)->create();
    }
}
