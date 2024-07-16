<?php

namespace App\Http\Requests\Admin;

use App\Enums\CountryStatus;
use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;

class CreateCityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name.*' => ["required", "string", "min:3","max:600"],
//            'name.ar'  => 'unique:cities,name->ar',
            "name.ar" => "required|unique:cities,name->ar,NULL,id,deleted_at,NULL",
            "name.en" => "required|regex:/(^[a-zA-Z])+/u|unique:cities,name->en,NULL,id,deleted_at,NULL",
            "spl_id" => "nullable|unique:cities,spl_id,NULL,id,deleted_at,NULL",

//            'name.en'  => 'regex:/(^[a-zA-Z])+/u',
            'area_id' => ["required"],
            'torod_city_id' => ["string"],
            "latitude" => ["required"],
            "longitude" => ["required"],
            "postcode" => ["required" , "numeric"],
            'is_active' => ["required", "in:". CountryStatus::ACTIVE .",". CountryStatus::INACTIVE],
//            'spl_id' => ["nullable", function($attribute, $value, $fail) {
//                $city = City::where($attribute, $value)->first();
//                if($city) {
//                    $fail(trans("admin.cities.validations.spl_id_unique"));
//                }
//            }]
        ];
    }

    /**
     * Set Custom validation messages.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            "area_id.required" => trans("admin.cities.validations.area_id_required"),
            "torod_city_id.string" => trans("admin.cities.validations.torod_city_id_string"),
            "latitude.required" => trans("admin.warehouses.validations.latitude_required"),
            "longitude.required" => trans("admin.warehouses.validations.longitude_required")
        ];
    }
}
