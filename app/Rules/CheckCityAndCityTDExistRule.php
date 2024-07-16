<?php

namespace App\Rules;

use App\Models\City;
use App\Models\LineShippingPrice;
use Illuminate\Contracts\Validation\Rule;

class CheckCityAndCityTDExistRule implements Rule
{
    protected $city_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($city)
    {
        $this->city_id = $city;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $city = City::find($value);
        $row_id = request()->line_id;
        $check_exist_city = LineShippingPrice::when($row_id , function($q) use ($row_id){
            $q->where('id' , '!=' , $row_id);
        })->where(function($q) use($city) {
            $q->where('city_id' , $city->id)->where('city_to_id' , $this->city_id)->orWhere(function($q2) use ($city){
                $q2->where('city_id' ,  $this->city_id)->where('city_to_id' , $city->id);
            });
        })->first();
        if($check_exist_city){
            return false;
        }
        return  true  ;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'المدن موجوده بالفعل';
    }
}
