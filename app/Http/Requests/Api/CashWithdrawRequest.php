<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;


class CashWithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bank_id' => 'required',
            'amount' => 'required|numeric',
            'bank_account_name' => 'required|string|max:250',
            'bank_account_iban' => 'required|string|max:250'
        ];
    }

    public function attributes()
    {
        return [
            'bank_id' => __('cashWithdrawRequest.attributes.bank_name'),
            'amount' => __('cashWithdrawRequest.attributes.amount'),
            'bank_account_name' => __('cashWithdrawRequest.attributes.bank_account_name'),
            'bank_account_iban' => __('cashWithdrawRequest.attributes.bank_account_iban'),

        ];
    }
    
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "message" => __('validation.some_field_missing'),
            "status"  => Response::HTTP_UNPROCESSABLE_ENTITY,
            "data"    => $validator->errors()

        ],Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
