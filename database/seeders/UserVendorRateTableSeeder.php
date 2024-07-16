<?php

namespace Database\Seeders;

use App\Models\UserVendorRate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserVendorRateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserVendorRate::factory(33)->create();
    }
}
