<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\User;
class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1= User::updateOrCreate(
            ['email'=>'mgebril360@gmail.com'],
            ['name'=>'Mahmoud Vendor','phone'=>'+9660511122255','password'=>'password','type'=>'vendor']
        );

        $user2= User::updateOrCreate(
            ['email'=>'kareem@info.me'],
            ['name'=>'Kareem Vendor','phone'=>'+9660511122233','password'=>'password','type'=>'vendor']
        );
        $vendor1 = Vendor::create([
            'is_active' => 1,
            'user_id' => $user1->id,
            'approval' => 'approved',
            'name' => [
                'en' => 'lovely Vendor',
                'ar' => 'تمور المحبة'
            ],
            'desc' => [
                'en' => 'lovely Vendor Description',
                'ar' => 'نبذة عن متجر تمور المحبة'
            ],
            "rate" => rand(1,5),
            'second_phone' => '+9660511122256',
        ]);

        $vendor2 = Vendor::create(
            [
                'is_active' => 1,
                'user_id' => $user2->id,
                'approval' => 'approved',
                'name' => [
                    'en' => 'kareem Vendor',
                    'ar' => 'كريم أشرف'
                ],
                'desc' => [
                    'en' => 'lovely Vendor Description',
                    'ar' => 'نبذة عن متجر تمور المحبة'
                ],
                "rate" => rand(1,5),
                'second_phone' => '+9660511122222',

            ]);

        $user1->vendor_id = $vendor1->id;
        $user1->save();

        $user2->vendor_id = $vendor2->id;
        $user2->save();
    }
}
