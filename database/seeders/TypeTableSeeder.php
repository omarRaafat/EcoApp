<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $main=Type::create(['order'=>1,'name'=>['en'=>'quantity type english','ar'=>'نوع الكمية ' ] ]);
    }
}
