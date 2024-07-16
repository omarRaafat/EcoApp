<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class VendorUserRequest extends FormRequest
{
    public const COUNTRY_CODE = "+966";

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
        if($this->method() == 'POST') {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255','unique:users'],
                'phone' => [
                    'required', 'max:10','min:10','regex:/^(05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/',
                    function ($attribute, $value, $fail) {
                        if(User::where("phone", self::COUNTRY_CODE . request()->phone)->vendorUser()->exists()) {
                            $fail(trans("vendors.registration.validations.phone_number_exists"));
                        }
                    }
                ],
                'password' => ['required','string','min:6','confirmed'],
                'vendor_id' => ['required', 'numeric'],
                'role_id' => ['required', 'numeric']
            ];
        }

        if($this->method() == 'PATCH') {
            $id = Request::segment(4);
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255','unique:users,email,' . $id],
                'phone' => [
                    'required', 'max:10','min:10','regex:/^(05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/',
                    function ($attribute, $value, $fail) use ($id) {
                        if(User::where("id", "!=", $id)->where("phone", self::COUNTRY_CODE . request()->phone)->vendorUser()->exists()) {
                            $fail(trans("vendors.registration.validations.phone_number_exists"));
                        }
                    }
                ],
            ];

            if(request()->has('type') && request('type') != 'vendor') {
                $rules['vendor_id'] = ['required', 'numeric'];
                $rules['role_id'] = ['required', 'numeric'];
            }

            if(request()->has('password') && request('password') != '') {
                $rules['password'] = ['string','min:6','confirmed'];
            }
        }
        return $rules;
    }
}
