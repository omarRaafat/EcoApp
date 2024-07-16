<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CodeGenerationRequest extends FormRequest
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
            'phone' => ["required", "min:9" ,'phone:AUTO', 'numeric']
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
            "phone.phone" => trans("validation.phone-not-valid"),
            "phone.min" => trans("validation.phone-min"),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,
            'message'   => trans('customer.validation_errors'),
            "status"    => 422,
            'data'      => $validator->errors()

        ],422));
    }
}
