<?php

namespace Database\Factories;

use App\Models\{User, Vendor};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserVendorRate>
 */
class UserVendorRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => User::where("type", "customer")->inRandomOrder()->first()->id,
            "vendor_id" => Vendor::inRandomOrder()->first()->id,
            "rate" => rand(1,5),
            "created_at" => now(),
            "updated_at" => now(),
            "deleted_at" => null
        ];
    }
}
