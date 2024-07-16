<?php

namespace App\Http\Requests\Admin;

use App\Models\Country;
use App\Enums\CountryStatus;
use App\Enums\NationalCountry;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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
            'name.*' => ["required", "string", "min:3",'max:600'],
            'code' => ["required", "string", "min:2"],
            'vat_percentage' => ["required", "numeric", "min:0", "max:99.99"],
            'is_active' => ["required", "in:". CountryStatus::ACTIVE .",". CountryStatus::INACTIVE],
            'is_national' => ["required", "in:". NationalCountry::NATIONAL .",". NationalCountry::NOTNATIONAL],
            'spl_id' => ["nullable", function($attribute, $value, $fail) {
                $country = Country::where($attribute, $value)->first();
                if($country && $country->id != $this->country_id) {
                    $fail(trans("admin.countries.validations.spl_id_unique"));
                }
            }],
            'minimum_order_weight' => 'nullable|required_with:maximum_order_weight,maximum_order_total|numeric|min:0.001|max:10000000',
            'maximum_order_weight' => 'nullable|required_with:maximum_order_total,minimum_order_weight|numeric|min:0.001|max:10000000|gte:minimum_order_weight',
            'maximum_order_total' => 'nullable|required_with:maximum_order_weight,minimum_order_weight|numeric|min:0.001|max:10000000',
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
            "name_ar.required" => trans("admin.countries.validations.name_ar_required"),
            "name_ar.string" => trans("admin.countries.validations.name_ar_string"),
            "name_ar.min" => trans("admin.countries.validations.name_ar_min"),
            "name_en.required" => trans("admin.countries.validations.name_en_required"),
            "name_en.string" => trans("admin.countries.validations.name_en_string"),
            "name_en.min" => trans("admin.countries.validations.name_en_min"),
            "code.required" => trans("admin.countries.validations.code_required"),
            "code.string" => trans("admin.countries.validations.code_string"),
            "code.min" => trans("admin.countries.validations.code_min")
        ];
    }

    public function attributes()
    {
        return [
            "vat_percentage" => "(". trans("admin.countries.vat_percentage") .")",
            "is_active" => "(". trans("admin.countries.is_active") .")",
            "is_national" => "(". trans("admin.countries.is_national") .")",
            "minimum_order_weight" => "(". trans("admin.countries.minimum_order_weight") .")",
            "maximum_order_weight" => "(". trans("admin.countries.maximum_order_weight") .")",
            "maximum_order_total" => "(". trans("admin.countries.maximum_order_total") .")",
        ];
    }
}
