<?php

namespace App\Http\Requests\Admin\Delivery;

use Illuminate\Foundation\Http\FormRequest;
class ShippingMethodSyncZonesRequest extends FormRequest
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
        $rules = [
            'domesticZones' => 'required|array|filled',
            'domesticZones.*' => 'required|exists:domestic_zones,id',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'domesticZones' => __('admin.shippingMethods.related-domestic-zones'),
            'domesticZones.*' => __('admin.shippingMethods.related-domestic-zones')
        ];
    }
}
