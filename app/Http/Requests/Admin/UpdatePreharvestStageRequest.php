<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreharvestStageRequest extends FormRequest
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
        $this->merge([
            'is_active' => $this->is_active == "on" ? true : false,
        ]);

        return [
            'name.*' => ["required", "string", "min:3","max:90"],
            'is_active' => ["boolean"],
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
            "is_active.boolean" => trans("admin.categories.validations.is_active_boolean"),
        ];
    }
}
