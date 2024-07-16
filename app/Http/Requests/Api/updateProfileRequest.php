<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class updateProfileRequest extends FormRequest
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
        $user = auth('api')->user();
        return [
            'name'=>'min:3',
            'email'=> ['nullable', 'email', function($attribute, $value, $fail) use($user) {
                $customer = User::where("email", $this->email)->where('type', UserTypes::CUSTOMER)->first();
                if($customer && $customer->id != $user->id) {
                    $fail(__('validation.email-unique'));
                }
            }],
            'phone'=> ['nullable','min:9','phone:AUTO', function($attribute, $value, $fail) use($user) {
                $customer = User::where("phone", $this->phone)->where('type', UserTypes::CUSTOMER)->first();
                if($customer && $customer->id != $user->id) {
                    $fail(__('validation.phone-unique'));
                }
            }],
            'country_code' => 'nullable|string|min:2|max:50',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => __('validation.name-min') ,
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
