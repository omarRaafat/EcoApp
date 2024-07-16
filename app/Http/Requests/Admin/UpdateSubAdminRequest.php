<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubAdminRequest extends FormRequest
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
            'name' => ["required", "string", "min:3", "max:80"],
            'email' => ["required", "max:250", "email", Rule::unique('users','email')->ignore($this->subAdmin_id)],
            'phone' => [
                'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'
            ],
            // 'password' => ["required", "string", "min:8"],
            'avatar' => ["image", "mimes:png,jpg"],
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
            "name.required" => trans("admin.subAdmins.validations.name_required"),
            "name.string" => trans("admin.subAdmins.validations.name_string"),
            "name.min" => trans("admin.subAdmins.validations.name_min"),
            "email.required" => trans("admin.subAdmins.validations.email_required"),
            "email.email" => trans("admin.subAdmins.validations.email_email"),
            "email.unique" => trans("admin.subAdmins.validations.email_unique"),
            "phone.required" => trans("admin.subAdmins.validations.phone_required"),
            "phone.min" => trans("admin.subAdmins.validations.phone_min"),
            "password.required" => trans("admin.subAdmins.validations.password_required"),
            "password.string" => trans("admin.subAdmins.validations.password_string"),
            "password.min" => trans("admin.subAdmins.validations.password_min"),
            "avatar.image" => trans("admin.subAdmins.validations.avatar_image"),
            "avatar.mimes" => trans("admin.subAdmins.validations.avatar_mimes")
        ];
    }

    public function attributes()
    {
        return [
            "name" => trans("admin.subAdmins.name"),
            "email" => trans("admin.subAdmins.email"),
            "phone" => trans("admin.subAdmins.phone"),
        ];
    }
}
