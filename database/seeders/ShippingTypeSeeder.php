<?php

namespace Database\Seeders;

use App\Models\ShippingType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_types')->delete();

        $records = [
            [
                'title' => ['ar'=> 'استلام','en' => 'receive'],
            ],
            [
                'title' => ['ar'=> 'توصيل','en' => 'deliver'],
            ],
        ];

        foreach ($records as $key => $record) {
            ShippingType::query()->create($record);
        }
    }
}
