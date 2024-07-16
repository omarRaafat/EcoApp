<?php

namespace App\Http\Requests\Vendor;

use App\Models\User;
use App\Enums\UserTypes;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    const COUNTRY_CODE = "+966";

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
        $this->merge(["phone" => self::COUNTRY_CODE . request()->phone]);

        return [
            'name'=>'required|min:3',
            'phone'=>['required', 'min:10', 'regex:/^(05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', function($attribute, $value, $fail) {
                $this->merge(["phone" => self::COUNTRY_CODE . $this->phone]);

                $user = User::where("phone", $this->phone)->whereIn('type', [UserTypes::VENDOR, UserTypes::SUBVENDOR])->first();
                    if($user && $user->id != auth()->user()->id) {
                        $this->merge([
                            "phone" => explode(self::COUNTRY_CODE, $this->phone)[1]
                        ]);
                        $fail(trans("vendors.registration.validations.phone_number_exists"));
                    }
            }],
            'email'=>['required', 'email',  function($attribute, $value, $fail) {
                $user = User::where("email", $this->email)->whereIn('type', [UserTypes::VENDOR, UserTypes::SUBVENDOR])->first();
                    if($user && $user->id != auth()->user()->id) {
                        $fail(trans("vendors.registration.validations.email_exists"));
                    }
            }]
        ];
    }
}
