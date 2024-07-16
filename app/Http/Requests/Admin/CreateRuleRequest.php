<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateRuleRequest extends FormRequest
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
            'name_ar' => ["required", "string", "min:3", "max:250"],
            'name_en' => ["required", "string", "min:3", "max:250"],
            'permissions' => ["required", "array", "present"]
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
            "name_ar.required" => trans("admin.rules.validations.name_ar_required"),
            "name_ar.string" => trans("admin.rules.validations.name_ar_string"),
            "name_ar.min" => trans("admin.rules.validations.name_ar_min"),
            "name_en.required" => trans("admin.rules.validations.name_en_required"),
            "name_en.string" => trans("admin.rules.validations.name_en_string"),
            "name_en.min" => trans("admin.rules.validations.name_en_min"),
            "permissions.required" => trans("admin.rules.validations.permissions_required"),
            "permissions.array" => trans("admin.rules.validations.permissions_array"),
            "permissions.present" => trans("admin.rules.validations.permissions_present"),
        ];
    }

    public function attributes()
    {
        return [
            "name_ar" => trans("admin.rules.name_ar"),
            "name_en" => trans("admin.rules.name_en"),
            "permissions" => trans("admin.rules.permissions.title"),
        ];
    }
}
