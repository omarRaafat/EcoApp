<?php

namespace Database\Factories;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vendor_id' => Vendor::inRandomOrder()->first()->id,
            'name' => ['ar' => 'مستودع '. fake("ar_EG")->city(), 'en' => fake("en_EG")->city() .' Warehouse'],
            "torod_warehouse_name" => fake("ar_SA")->text(8),
            //"integration_key" => WarehouseIntegrationKeys::NATIONAL_WAREHOUSE,
            "administrator_name" => fake()->name('male'),
            "administrator_phone" => fake()->numerify("5########"),
            "administrator_email" => fake()->email(),
            "latitude" => fake()->latitude(),
            "longitude" => fake()->longitude(),
        ];
    }
}
