<?php

namespace App\Http\Requests\Api\Eportal;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
//        $maxYear = (intval(\Helper::getHijriYear()) - 17);

        return [
            'identity'  => 'required|digits:10|starts_with:1|regex:/^[0-9]+$/',
            'phone'     => 'required|digits:10|starts_with:05|regex:/^[0-9]+$/',
//            'phone' => 'required|digits:10|regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})+$/',
            'day'       => 'required|numeric|min:1|max:31',
            'month'     => 'required|numeric|min:1|max:12',
            // 'year'      => 'required|numeric|min:1300|max:'.$maxYear,
            'year'      => 'required|numeric|min:1300',
        ];
    }
}
