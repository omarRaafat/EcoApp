<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Currency::truncate();
        $statement = "ALTER TABLE currencies AUTO_INCREMENT = 1;";
        DB::unprepared($statement);

        $name['ar']= 'الريال السعودى';
        $name['en']= 'Saudi riyal';
        Currency::create(['name' => $name,
        'code' => 'SAR',]);
//
//        $name['ar']= 'الجنية المصرى';
//        $name['en']= 'Egyption Pound';
//        Currency::create(['name' => $name,
//        'code' => 'ُEGP',]);


        //Currency::factory(1)->create();

    }
}
