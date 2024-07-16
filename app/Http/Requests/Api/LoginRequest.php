<?php

namespace App\Http\Requests\Api;

use App\Rules\VerificationCodeLengthRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone' => ["required", "min:9",'phone:AUTO', 'numeric'],
            'code' => ["required", "integer", new VerificationCodeLengthRule] 
        ];
    }

    /**
     * Get the validation messages that apply to the validation roles.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            "phone.required" => trans("validation.phone-required"),
            "phone.min" => trans("validation.phone-min"),
            "code.required" => trans("validation.code-required"),
            "code.integer" => trans("validation.code-integer"),
            "code.min" => trans("validation.code-min"),
            "phone.phone" => trans("validation.phone-not-valid"),
        ];
    }
}
