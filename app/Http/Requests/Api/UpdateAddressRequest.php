<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateAddressRequest
 extends FormRequest
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
            'type'       =>'nullable|in:work,home',
            'address_id' =>'required',
            'phone'      =>'required|phone:AUTO|numeric',
            'city_id'    => [ "required",'exists:cities,id'],
        ];
    }

    public function messages()
    {
        return [
            'last_name.required'   => __('validation.first_name-required') ,
            'first_name.required'  => __('validation.last_name-required'),
            'description.required' => __('validation.description-required'),
            'type.in'              =>__('validation.invalid_type'),
            'type.required'        => __('validation.type-required'),
            'lat.required'         => __('validation.lat-required'),
            'long.required'        => __('validation.long-required'),
            'phone.phone'          => __('validation.phone-invalid'),
            'city_id.required'     => __('validation.city_id-required'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => trans('customer.validation_errors'),
            "status"  => 422,
            'data'    => $validator->errors()

        ],422));
    }
}
