<?php

namespace App\Http\Requests\Api;

use App\Models\Product;
use App\Rules\CheckStockInProductRule;
use App\Rules\CheckStockInWarehouseRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class EditCartProduct extends FormRequest
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
            // 'city_id' => 'nullable|numeric|exists:cities,id',
            'product_id' =>  'required|exists:products,id',
            'quantity' => ['required','numeric' , 'min:1' , new CheckStockInProductRule($this) ],
            // 'warehouse_id' => ['nullable','numeric','exists:warehouses,id' , new CheckStockInWarehouseRule($this) ],
            // 'shipping_type_id' => ['nullable','numeric','exists:shipping_types,id' ],
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'product_id.required'  => __('validation.product-required'),
    //         // 'city_id.required'  => __('validation.city_id-required'),
    //         'quantity.required'  => __('validation.quantity-required'),
    //         // 'warehouse_id.required'  => __('validation.warehouse_id-required'),
    //         // 'shipping_type_id.required'  => __('validation.shipping_type_id-required'),
    //     ];
    // }
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
