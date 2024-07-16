<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\DomesticZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomesticZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::limit(30)->get()->chunk(10)->each(function ($cities) {
            $domesticZone = DomesticZone::factory(1)->create()->first();
        });
    }
}
