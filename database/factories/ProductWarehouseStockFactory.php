<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductWarehouseStockFactory extends Factory
{

    public function definition(): array
    {
        return [
            'product_id' => Product::all()->random()->id,
            'warehouse_id'  => Warehouse::all()->random()->id,
            'stock'  => 100,
        ];
    }
}
