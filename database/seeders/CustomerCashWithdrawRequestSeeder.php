<?php

namespace Database\Seeders;

use App\Models\CustomerCashWithdrawRequest;
use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerCashWithdrawRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $customer = User::where('type', 'customer')->first();
        
        if (!$customer) {
            $customer = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                "phone" => $faker->PhoneNumber,
                "type" => "customer",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
        }

        $data = collect([]);
        for($i = 0; $i < 3; $i++)
            $data->push([
                'customer_id' => $customer->id,
                'bank_name' => $faker->name(),
                'amount' => $faker->numerify("##.#"),
                'bank_account_name' => $faker->name(),
                'bank_account_iban' => $faker->iban(null, 'KSA-'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        CustomerCashWithdrawRequest::insert($data->toArray());
    }
}
