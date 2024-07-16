<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePalmLengthRequest extends FormRequest
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
            'from' => 'required|integer|min:1',
            'to' => 'required|integer|gt:from',
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
            "to.gt" => trans("admin.palm-length.validations.to_gt"),
        ];
    }
}
