<?php

namespace App\Http\Requests\Api;

use App\Models\Country;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreAddressRequest extends FormRequest
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

        $isCountryNational =  request()->country_id ? Country::find(request()->country_id)->is_national: false;

        return [
            'first_name'    => 'required',
            'last_name'     =>  'required',
            'phone'         =>  'required|phone:AUTO|numeric',
            'country_id'    =>'required|exists:countries,id',
            'area_id'       => [ Rule::requiredIf($isCountryNational), 'exists:areas,id'],
            'city_id'       => [ "required", 'exists:cities,id'],
            'type'          =>'nullable|in:work,home',
            'description'   =>'required',
            'is_default'    =>'boolean',
        ];
    }
    public function messages()
    {
        return [
            'last_name.required'          => __('validation.first_name-required') ,
            'first_name.required'         => __('validation.last_name-required'),
            'description.required'        => __('validation.description-required'),
            'type.in'                     =>__('validation.invalid_type'),
            'type.required'               => __('validation.type-required'),
            'country_id.required'         => __('validation.country_id-required'),
            'area_id.required'            => __('validation.area_id-required'),
            'city_id.required'            => __('validation.city_id-required'),
            'international_city.required' => __('validation.international_city-required'),
            "phone.required"              =>__('validation.phone-required'),
            "phone.phone"                 =>__('validation.phone-invalid'),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => __('validation.some_field_missing'),
            "status"  => 422,
            'data'    => $validator->errors()
        ],422));
    }
}
