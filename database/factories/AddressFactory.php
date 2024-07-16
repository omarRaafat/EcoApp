<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletTransactionHistory>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $country = Country::inRandomOrder()->first()->id;
        $area = Area::where('country_id',$country)->inRandomOrder()->first()->id;
        $city = City::where('area_id',$area)->inRandomOrder()->first()->id;
        $user = User::where("type", "customer")->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'description' => fake()->paragraph,
            'type' => fake()->randomElement(['home', 'work']),
            'is_default' => fake()->randomElement([0,1]),
            'country_id' => $country,
            'area_id' => $area,
            'city_id' => $city,
            'phone' => fake()->phoneNumber,
        ];
    }
}
