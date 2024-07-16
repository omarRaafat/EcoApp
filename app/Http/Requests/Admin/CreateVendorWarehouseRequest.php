<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateVendorWarehouseRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'vendor_id' => 'required',
            'requestItems' => 'required|filled',
            'requestItems.*.product_id' => 'required',
            'requestItems.*.qnt' => 'required|numeric|min:1|max:1000000',
            'requestItems.*.mnfg_date' => 'required|date_format:Y-m-d',
            // 'requestItems.*.expire_date' => 'required|date_format:Y-m-d|after:requestItems.*.mnfg_date'
        ];
    }

    public function attributes()
    {
        app()->setLocale('ar');
        return [
            'vendor_id' => __('admin.wareHouseRequests.vendor'),
            'requestItems' => __('admin.wareHouseRequests.requestItems'),
            'requestItems.*.product_id' => __('admin.wareHouseRequests.product'),
            'requestItems.*.qnt' => __('admin.wareHouseRequests.qnt'),
            'requestItems.*.mnfg_date' => __('admin.wareHouseRequests.mnfg_date'),
            'requestItems.*.expire_date' => __('admin.wareHouseRequests.expire_date'),
        ];
    }

    public function messages()
    {
        return [
            'requestItems.*.expire_date.after' => __('admin.wareHouseRequests.validations.expire_date_after'),
        ];
    }
}
