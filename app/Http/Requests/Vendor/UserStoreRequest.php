<?php

namespace App\Http\Requests\Vendor;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    const COUNTRY_CODE = "+966";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->method()=='POST') {
            $rules=[
                'name'=>'required|min:3',
                'email'=>'required|unique:users',
                'phone' => [
                    'required', 'max:10','min:10','regex:/^(05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/',
                    function($attribute, $value, $fail) {
                        if(User::where("phone", self::COUNTRY_CODE . request()->phone)->vendorUser()->exists()) {
                            $fail(trans("vendors.registration.validations.phone_number_exists"));
                        }
                    }
                ],
                'password'=>'required|min:8|confirmed',
                'type_of_employee_id' => 'required|exists:type_of_employees,id'
            ];
        }

        if ($this->method()=='PATCH') {
            $id=Request::segment(3);
            $rules=[
                'name'=>'required|min:3',
                'email'=>'required|unique:users,email,'.$id,
                'type_of_employee_id' => 'required|exists:type_of_employees,id',
                'phone' => [
                    'required', 'max:10','min:10','regex:/^(05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/','unique:users,phone,'.$id ,
                    function($attribute, $value, $fail) use ($id) {
                        if(User::where("phone", self::COUNTRY_CODE . request()->phone)->where('id', '!=', $id)
                        ->vendorUser()->exists()) {
                            $fail(trans("vendors.registration.validations.phone_number_exists"));
                        }
                    }
                ],
            ];
            if(request('password') != null){
                $rules['password']='min:8|confirmed';
                $rules['password_confirmation'] = 'required|min:8';
            }
        }
        return $rules;
    }
}
