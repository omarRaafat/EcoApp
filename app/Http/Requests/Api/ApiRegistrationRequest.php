<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRegistrationRequest extends FormRequest
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
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=> ['nullable', 'email',  function($attribute, $value, $fail) {
                $usersCount = User::where("email", $this->email)->where('type', UserTypes::CUSTOMER)->count();
                    if($usersCount > 0) {
                        $fail(__('validation.email-unique'));
                    }
            }],
            'phone'=> ['required', 'min:9', 'phone:AUTO', function($attribute, $value, $fail) {
                $usersCount = User::where("phone", $this->phone)->where('type', UserTypes::CUSTOMER)->count();
                    if($usersCount > 0) {
                        $fail(__('validation.phone-unique'));
                    }
            }],
            'country_code' => 'nullable|string|min:2|max:50',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('validation.first_name-required') ,
            'last_name.required'  => __('validation.last_name-required'),
            'phone.required'      => __('validation.phone-required'),
            'country_id.required' => __('validation.country_id-required'),
            'phone.unique'        => __('validation.phone-unique'),
            'email.unique'        => __('validation.email-unique'),
            'phone.min'           => __('validation.phone-min'),
            "phone.phone"         => trans("validation.phone-not-valid"),

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,
            'message'   => trans('customer.validation_errors'),
            "status" => 422,
            'data'      => $validator->errors()

        ],422));
    }
}
