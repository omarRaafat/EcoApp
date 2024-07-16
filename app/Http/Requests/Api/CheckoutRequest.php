<?php

namespace App\Http\Requests\Api;

use App\Enums\PaymentMethods;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CheckoutRequest extends FormRequest
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
        $validPaymentMethods = implode(',', [
            PaymentMethods::WALLET,
            PaymentMethods::VISA,
            PaymentMethods::TABBY,
        ]);
        
        return [
            'coupon_code' => 'nullable' ,
            'payment_id' => 'required|in:'.$validPaymentMethods,
            // 'use_wallet' => 'nullable|in:0,1',
            'vendors' => 'required|array',
            'vendors.*.vendor_id' =>  ['required','exists:vendors,id'],
            'vendors.*.use_wallet' =>  'in:0,1',
            'vendors.*.wallet_id' =>  'nullable|required_if:payment_id,==,3|required_if:vendors.*.use_wallet,==,1',
            // 'vendors.*.wallet_amount' =>  'required_if:payment_id,==,3|numeric',
        ];
    }

    public function messages()
    {
        return [
            'payment_id.required' => __('cart.api.checkout.payment_id_required'),
            'payment_id.required' => __('cart.api.checkout.payment_id_in'),
            'vendors.requird' => __('cart.api.checkout.vendors_required'),
            'vendors.array' => __('cart.api.checkout.vendors_array'),
            'vendors.*.vendor_id.required' => __('cart.api.checkout.vendor_id_required'),
            'vendors.*.vendor_id.exists' => __('cart.api.checkout.vendor_id_exists'),
            'vendors.*.use_wallet.in' => __('cart.api.checkout.use_wallet_in'),
            'vendors.*.wallet_id.required_if' => __('cart.api.checkout.wallet_id_required_if'),
            'vendors.*.wallet_id.required_if2' => __('cart.api.checkout.wallet_id_required_if2'),
            'vendors.*.wallet_id.numeric' => __('cart.api.checkout.wallet_id_numeric'),
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'success'   => false,
    //         'message'   => __('validation.some_field_missing'),
    //         "status" => 500,
    //         'data'      => $validator->errors()
    //     ], 500));
    // }
}
