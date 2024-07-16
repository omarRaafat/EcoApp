<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Certificate;

class CertificateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Certificate::create(['title'=>['ar'=>'شهادة اﻷيزو','en'=>'ISO Certificate']]);
        Certificate::create(['title'=>['ar'=>'إدارة الجودة الشاملة','en'=>'TQM']]);
    }
}
