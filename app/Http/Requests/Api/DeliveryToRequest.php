<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DeliveryToRequest extends FormRequest
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
            'code' => ['required',Rule::exists('countries','code')->where('is_active',1)],

        ];
    }
    public function messages()
    {
        return [
            'code.required' => __('validation.code_required') ,
            'code.exists'  => __('validation.code_exists'),

        ];
    }
    /**
     * Validatior function
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => __('validation.some_field_missing'),
            "status" => 422,
            'data'      => $validator->errors()

        ],422));
    }
}
