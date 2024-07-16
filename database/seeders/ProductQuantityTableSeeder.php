<?php

namespace Database\Seeders;

use App\Models\ProductQuantity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductQuantityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_quantities')->delete();

        $records = [
                [
                    "name" => ["ar" => "كيلو","en" => "Kilo",],
                    "is_active" => true
                ],
                [
                    "name" => ["ar" => "جرام","en" => "gram"],
                    "is_active" => true
                ]
            ];
        foreach ($records as $record) {
            ProductQuantity::query()->create($record);
        }
    }
}
