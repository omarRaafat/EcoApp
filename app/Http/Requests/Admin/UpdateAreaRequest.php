<?php

namespace App\Http\Requests\Admin;

use App\Enums\CountryStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
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
            'country_id' => ["required"],
            'is_active' => ["required", "in:". CountryStatus::ACTIVE .",". CountryStatus::INACTIVE],
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
            // "name_ar.required" => trans("admin.areas.validations.name_ar_required"),
            // "name_ar.string" => trans("admin.areas.validations.name_ar_string"),
            // "name_ar.min" => trans("admin.areas.validations.name_ar_min"),
            // "name_en.required" => trans("admin.areas.validations.name_en_required"),
            // "name_en.string" => trans("admin.areas.validations.name_en_string"),
            // "name_en.min" => trans("admin.areas.validations.name_en_min"),
            "country_id.required" => trans("admin.areas.validations.country_id_required")
        ];
    }

    public function attributes()
    {
        return [
            "is_active" => "(". trans("admin.countries.is_active") .")",
        ];
    }
}
