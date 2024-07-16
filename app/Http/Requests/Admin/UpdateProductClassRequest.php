<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductClassRequest extends FormRequest
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
            'name.*' => ["required", "string", "min:3",'max:200'],

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
            // "name_ar.required" => trans("admin.productClasses.validations.name_ar_required"),
            // "name_ar.string" => trans("admin.productClasses.validations.name_ar_string"),
            // "name_ar.min" => trans("admin.productClasses.validations.name_ar_min"),
            // "name_en.required" => trans("admin.productClasses.validations.name_en_required"),
            // "name_en.string" => trans("admin.productClasses.validations.name_en_string"),
            // "name_en.min" => trans("admin.productClasses.validations.name_en_min")
        ];
    }
}
