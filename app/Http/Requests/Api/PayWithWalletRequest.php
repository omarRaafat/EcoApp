<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PayWithWalletRequest extends FormRequest
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
            'address_id' => 'required|numeric',
            'use_wallet' => 'required|boolean',
            'shipping_id' => 'required|exists:shipping_methods,id',
        ];
    }

    public function attributes()
    {
        return [
            'address_id' => __('cart.api.checkout.address_id'),
            'use_wallet' => __('cart.api.checkout.use_wallet'),
            'shipping_id' => __('cart.api.checkout.shipping_id'),
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
