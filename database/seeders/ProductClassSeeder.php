<?php

namespace Database\Seeders;

use App\Models\ProductClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductClass::create([
            "name" => [
                "ar" => "درجة ممتاز",
                "en" => "Excellent Class",
            ],
        ]);
        ProductClass::create([
            "name" => [
                "ar" => "درجة اولي",
                "en" => "First Class",
            ],
        ]);
        ProductClass::create([
            "name" => [
                "ar" => "درجة ثانية",
                "en" => "Second Class",
            ],
        ]);
    }
}
