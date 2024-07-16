<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class AvailableMethodsRequest extends FormRequest
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
//            'address_id' => [
//                    'nullable',
//                     Rule::exists('addresses', 'id')
//                     ->where('user_id', auth('api')->user()->id)
//                    ],
            'city_id'   => 'required|exists:cities,id'

        ];
    }

    public function messages()
    {
        return [
            "city_id.required" => trans("address.api.required"),
            "city_id.exists"   => trans("address.api.not_found"),

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => trans('customer.validation_errors'),
            "status" => 422,
            'data'      => $validator->errors()
        ],500));
    }
}
