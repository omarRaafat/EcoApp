<?php

namespace App\Http\Requests\Admin\Delivery;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ShippingMethodKeys;
use App\Enums\ShippingMethodType;

class CreateShippingMethodRequest extends FormRequest
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
        $this->merge([
            'is_active' => $this->is_active == "on" ? true : false,
        ]);

        $rules = [
            "name.*" => "required|string|min:3|max:250",
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'integration_key' => 'required|unique:shipping_methods,integration_key|in:'. implode(',',ShippingMethodKeys::getKeysArray()),
            'cod_collect_fees' => "nullable|numeric|min:0|max:10000000",
            'type' => 'required|in:'.implode(',',ShippingMethodType::getTypes()),
            'is_active' => "boolean",
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            "name.ar" => "(". __('admin.shippingMethods.name') ." ". __("language.ar") .")",
            "name.fr" => "(". __('admin.shippingMethods.name') ." ". __("language.fr") .")",
            "name.gr" => "(". __('admin.shippingMethods.name') ." ". __("language.gr") .")",
            "name.id" => "(". __('admin.shippingMethods.name') ." ". __("language.id") .")",
            "name.en" => "(". __('admin.shippingMethods.name') ." ". __("language.en") .")",
            "logo" => "(". __('admin.shippingMethods.logo') .")",
            "integration_key" => "(". __('admin.shippingMethods.integration_key') .")",
            "cod_collect_fees" => "(". __('admin.shippingMethods.cod_collect_fees') .")",
            "type" => "(". __('admin.shippingMethods.type') .")",
        ];
    }
}
