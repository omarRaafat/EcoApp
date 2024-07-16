<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use App\Models\Vendor;
use App\Enums\VendorPermission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>['en'=>'Supervisor','ar'=>'مشرف'],
            'permissions'=>json_encode([VendorPermission::ORDERS,VendorPermission::PRODUCT]),
            'vendor_id'=>Vendor::inRandomOrder()->first()->id
        ];
    }
}
