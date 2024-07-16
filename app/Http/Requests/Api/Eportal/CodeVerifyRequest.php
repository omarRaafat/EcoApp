<?php

namespace App\Http\Requests\Api\Eportal;

use Illuminate\Foundation\Http\FormRequest;

class CodeVerifyRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
//            'phone'         => 'required|digits:10|starts_with:05|regex:/^[0-9]+$/',
            'identity'      => 'required|digits:10|starts_with:1|regex:/^[0-9]+$/',
            'code_verify'   => 'required',
        ];
    }
}
