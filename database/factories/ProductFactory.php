<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\ProductClass;
use App\Models\ProductQuantity;
use App\Models\Vendor;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category         = Category::whereNull('parent_id')->first();
        $subCategory      = Category::where('parent_id', $category->id)->first();
        $finalSubCategory = Category::where('parent_id', $category->id)->first();

        $price=rand(50,1000);
        return [
            'name' => ['en'=>fake()->sentence(6),'ar'=>fake("ar_EG")->sentence()],
            'desc' => ['en'=>fake()->paragraph(6),'ar'=>fake("ar_EG")->paragraph()],
            'is_active' => 1,
            'status' => 'accepted',
            'total_weight' => rand(10,100),
            'net_weight' => rand(0,20),
            'length' => rand(5,50),
            'width' => rand(5,30),
            'height' => rand(5,30),
            'price' => $price,
            'price_before_offer' => $price-1500,
            'order' => rand(1,300),
            'category_id' => $category->id,
            'sub_category_id' => $subCategory->id,
            'final_category_id' => $finalSubCategory->id,
            'is_visible' => true,//rand(0,1),
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'quantity_type_id' => ProductQuantity::inRandomOrder()->first()->id,
            'type_id' => ProductClass::inRandomOrder()->first()->id,
            'stock' => 0, //rand(21,963)
        ];
    }
}
