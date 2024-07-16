<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $vendorUser = User::factory()->create(["type" => "vendor"]);
      
        return [
            'is_active' => 1,
            'user_id' => $vendorUser->id,
            'second_phone' => fake()->phoneNumber(),
            'approval' => 'approved',
            'name' => [
                'en' => fake()->name(),
                'ar' => fake("ar_EG")->name()
            ],
            'desc' => [
                'en' => fake()->text(),
                'ar' => fake("ar_EG")->text(),
            ],
            "rate" => rand(1,5)
        ];
    }
}
