<?php

namespace App\Http\Requests\Api;

use App\Rules\CheckCityWithShippingMethodRule;
use App\Rules\CheckProductExistInVendorRule;
use App\Rules\CheckProductWeightForShippingRule;
use App\Rules\CheckStockInWarehouseRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SyncCartProduct extends FormRequest
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
            'cart' => 'required',
            'cart.city_id' => ['required','exists:cities,id'],
            'cart.vendors' => 'required|array',
            // 'cart.vendors.*.vendor_id' => ['required','exists:vendors,id' ,  new CheckCityWithShippingMethodRule($this)],
            'cart.vendors.*.vendor_id' => ['required','exists:vendors,id'],
            'cart.vendors.*.shipping_type_id' => ['required' ,'exists:shipping_types,id' , "in:1,2"],
            'cart.vendors.*.shipping_method_id' => ['required_if:cart.vendors.*.shipping_type_id,2' , new CheckProductWeightForShippingRule($this)],
            'cart.vendors.*.products' => 'required|array',
            'cart.vendors.*.products.*.product_id' => ['required','exists:products,id', new CheckProductExistInVendorRule($this) ],
            // 'cart.vendors.*.products.*.product_id' => ['required','exists:products,id'],
            'cart.vendors.*.products.*.quantity' => 'required|numeric',
            'cart.vendors.*.products.*.warehouse_id' => ['required_if:cart.vendors.*.shipping_type_id,1' , new CheckStockInWarehouseRule($this)  ],
        ];
    }

    public function messages()
    {
        return  [
            'cart' => __('validation.cart-required'),
            'cart.city_id.required'  => __('validation.city_id-required'),
            'cart.city_id.exists'  => __('validation.city_id-exists'),
            'cart.vendors.*.vendor_id' =>  __('validation.vendor_id-required') ,
            'cart.vendors.*.vendor_id.exists' =>  __('validation.vendor_id-exists') ,
            'cart.vendors.*.shipping_type_id.required'  => __('validation.shipping_type_id-required'),
            'cart.vendors.*.shipping_type_id.exists'  => __('validation.shipping_type_id-exists'),

            'cart.vendors.*.shipping_method_id.required_if'  => __('validation.shipping_method_id-required_if'),
            'cart.vendors.*.shipping_method_id.exists'  => __('validation.shipping_method_id-exists'),

            'cart.vendors.*.shipping_type_id.in'  => __('validation.shipping_type_id-in'),
            'cart.vendors.*.products.*.product_id.required'  => __('validation.product-required'),
            'cart.vendors.*.products.*.quantity.required'  => __('validation.quantity-required'),
            'cart.vendors.*.products.*.quantity.numeric'  => __('validation.quantity-numeric'),
            'cart.vendors.*.products.*.quantity.numeric'  => __('validation.quantity-numeric'),
            'cart.vendors.*.products.*.warehouse_id.required_if'  => __('validation.warehouse_id-required_if'),
            // 'cart.vendors.*.products.*.city_id.required_if'  => __('validation.city_id-required_if'),
        ];

    }


    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'success'   => false,
    //         'message'   => trans('customer.validation_errors'),
    //         "status" => 500,
    //         'data'      => $validator->errors()
    //     ],500));
    // }
}
