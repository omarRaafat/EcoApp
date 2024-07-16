<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductScrollTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendors = Vendor::factory(20)->create();
        
        $firstVendor = $vendors->first();
        
        $category = Category::create([
            'name' => [
                "ar" => "تمور",
                "en" => "Tomor"
            ],
            'slug' => [
                "ar" => "تمور",
                "en" => "tomor"
            ],
            'parent_id' => null,
            'level' => 1,
            'is_active' => true,
        ]);

        Product::factory(30)->create([
            "image" => "",
            "vendor_id" => $firstVendor->id,
            "category_id" => $category->id,
            'is_visible' => 1,
            'status' => "accepted",
            'stock' => 5
        ]);
    }
}
