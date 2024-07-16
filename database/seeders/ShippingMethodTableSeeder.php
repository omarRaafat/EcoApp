<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_methods')->delete();

        $records = [
            [
                'id'                    => 1,
                'name'                  => ["en" => 'ARAMEX' , 'ar' => 'أرامكس'],
                'integration_key'       => "international-shipping-method-ARAMEX",
                'type'                  => 'national',
                'cod_collect_fees'      => 0,
            ],
            [
                'id'                    => 2,
                'name'                  => ["en" => 'SPL' , 'ar' => 'سبل'],
                'integration_key'       => "international-shipping-method-SPL",
                'cod_collect_fees'      => 0,
                'type'                  => 'national',
            ],

        ];

        foreach ($records as $record) {
            ShippingMethod::query()->create($record);
        }
    }
}
