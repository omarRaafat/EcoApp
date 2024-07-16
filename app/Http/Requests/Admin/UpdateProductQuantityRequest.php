<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductQuantityRequest extends FormRequest
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
            'is_active' => ["required", "boolean"],
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
            "is_active.required" => trans("admin.productQuantities.validations.is_active_required"),
            "is_active.boolean" => trans("admin.productQuantities.validations.is_active_boolean")
        ];
    }
}
