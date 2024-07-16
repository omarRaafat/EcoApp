<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            "name" => [
                "ar" => "البنك التجاري الدولي",
                "en" => "CIB"
            ],
            "is_active" => true
        ]);

        Bank::create([
            "name" => [
                "ar" => "مؤسسة هونغ كونغ وشنغهاي المصرفية",
                "en" => "HSBC"
            ],
            "is_active" => true
        ]);

        Bank::create([
            "name" => [
                "ar" => "كريدى اجريكول",
                "en" => "Credit Agricole"
            ],
            "is_active" => true
        ]);
    }
}
