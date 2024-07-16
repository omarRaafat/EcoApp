<?php

namespace App\Http\Requests\Admin;

use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
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
        $id = $this->city ?? null;
        return [
            'name.*' => ["required", "string", "min:3","max:600"],
//            'name.ar'  => 'required|unique:cities,name->ar,'.$id,
//            'name.en'  => 'regex:/(^[a-zA-Z])+/u',
            'name.ar' => "required|unique:cities,name->ar,{$id},id,deleted_at,NULL",
            'name.en' => "required|unique:cities,name->en,{$id},id,deleted_at,NULL",
            'spl_id' => "required|unique:cities,spl_id,{$id},id,deleted_at,NULL",

//            "spl_id" => "required|unique:cities,spl_id,{$id},id,deleted_at,NULL",

            'area_id' => ["required"],
            'torod_city_id' => ["string"],
            "latitude" => ["required"],
            "longitude" => ["required"],
            "postcode" => ["required" , "numeric"],
            'spl_id' => ["nullable", function($attribute, $value, $fail) {
                $city = City::query()->where($attribute, $value)->whereNull('deleted_at')->first();
                if($city && $city->id != $this->city_id) {
                    $fail(trans("admin.cities.validations.spl_id_unique"));
                }
            }]
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
            // "name_ar.required" => trans("admin.countries.validations.name_ar_required"),
            // "name_ar.string" => trans("admin.countries.validations.name_ar_string"),
            // "name_ar.min" => trans("admin.countries.validations.name_ar_min"),
            // "name_en.required" => trans("admin.countries.validations.name_en_required"),
            // "name_en.string" => trans("admin.countries.validations.name_en_string"),
            // "name_en.min" => trans("admin.countries.validations.name_en_min"),
            "area_id.required" => trans("admin.cities.validations.area_id_required"),
            "torod_city_id.string" => trans("admin.cities.validations.torod_city_id_string"),
            "latitude.required" => trans("admin.warehouses.validations.latitude_required"),
            "longitude.required" => trans("admin.warehouses.validations.longitude_required")
        ];
    }
}
