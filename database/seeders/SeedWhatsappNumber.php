<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Enums\SettingEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeedWhatsappNumber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate([
            "key" => SettingEnum::whatsapp
        ],[
            'key'=> SettingEnum::whatsapp ,
            'value'=>'00 996 6000 5776' ,
            'type' => 'contact_info' ,
            'editable'=>1 ,
            'input_type'=>'phone' ,
            'scope' =>'global',
            'desc'=>'رقم الواتساب'
        ]);
    }
}
