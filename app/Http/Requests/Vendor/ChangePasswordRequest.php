<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->user())?true:false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password'=>[
                'required',
                'max:200',
                function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, auth()->user()->password) ) {
                        $fail(__('validation.wrong_password'));
                    }
                },
            ],
            'password'=>'required|min:8|max:200|confirmed'
        ];
    }
}
