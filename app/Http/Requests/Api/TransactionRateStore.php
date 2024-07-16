<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRateStore extends FormRequest
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
            'vendors' => "required|array",
            'vendors.*.id' => "required|exists:vendors,id",
            'vendors.*.rate' => "nullable|numeric|min:1|max:5",
            'vendors.*.products' => "nullable|array",
            'vendors.*.products.*.id' => "required|exists:products,id",
            'vendors.*.products.*.rate' => "nullable|numeric|min:1|max:5",
            'vendors.*.products.*.review' => "nullable|string|min:3|max:190",
        ];
    }

    public function messages()
    {
        return [
            'vendors.0.rate.min' => 'يجب أن يكون معدل تقييم البائع يساوي أو أكبر من 1.',
            'vendors.0.products.0.rate.min' => 'يجب أن يكون معدل معدل تقييم المنتج يساوي أو أكبر من 1.',
        ];
    }
}
