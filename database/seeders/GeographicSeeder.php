<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeographicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Country::create([
//            'name' => ['ar' => "مصر", 'en' => "Egypt"],
//            'code' => 'eg',
//        ]);
        Country::create([
            'name' => ['ar' => "السعودية", 'en' => "Saudi Arabia"],
            'code' => 'sa',
            'is_national' => 1
        ]);
        Country::all()->each(function ($country) {
            for ($i = 0; $i < 3; $i++) {
                $country->areas()->create([
                    'name' => ['ar' => fake('ar_EG')->city(), 'en' => fake('en_EG')->city()],
                ]);
            }
            $country->areas->each(function ($area) {
                for ($i = 0; $i < 3; $i++) {
                    $area->cities()->create([
                        'name' => ['ar' => fake('ar_EG')->city(), 'en' => fake('en_EG')->city()],
                    ]);
                }
            });
        });
    }
}
