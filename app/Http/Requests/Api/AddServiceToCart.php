<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddServiceToCart extends FormRequest
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
            "service_id" => 'required|exists:services,id',
            "quantity" => "required|integer",
            "city_id" => "nullable|exists:cities,id",
            // 'serviceAddress' => 'nullable|min:10',
            // 'serviceDate' => 'nullable|date|before_or_equal:today',
            'service_fields' => ['nullable','array'],
            // 'service_fields.*' => 'required',
            // 'service_fields.*.key' => 'unique:cart_product_service_fields,key'
        ];
    }
}
