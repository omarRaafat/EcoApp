<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name.*' => ["required", "string", "min:3","max:90"],
            'torod_warehouse_name' => ["string"],
            "administrator_name" => ["required"],
            "administrator_phone" => ["required"],
            "administrator_email" => ["required"],
            'address.ar'  => 'nullable',
            'address.en'  => 'required',
            // "map_url" => ["required", "url"],
            "latitude" => ["required"],
            "longitude" => ["required"],
            /*"additional_unit_price" => ["required", "numeric", "min:0", "max:1000000"],
            "package_covered_quantity" => ["nullable", "integer", "min:0", "max:1000000"],
            "package_price" => ["required", "numeric", "min:0", "max:1000000"],*/
            "cities" => ["required", "array"],
            "cities.*" => ["required", "exists:cities,id"],
//            "countries" => ["required", "array"],
//            "countries.*" => ["required", "exists:countries,id"],
//            "api_key" => "required|unique:warehouses,api_key,{$this->warehouse_id},id",
            "shipping_type" => "required|array|exists:shipping_types,id",
            "postcode" => ["required" , "numeric"],
            'spl_branch_id' => [ 'nullable'],
            'days' => [ 'nullable'],
            'time_work_from' => [ 'nullable'],
            'time_work_to' => [ 'nullable']
        ];
    }

    /**
     * Set Custom validation messages.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            "name_ar.required" => trans("admin.warehouses.validations.name_ar_required"),
            "name_ar.string" => trans("admin.warehouses.validations.name_ar_string"),
            "name_ar.min" => trans("admin.warehouses.validations.name_ar_min"),
            "name_en.required" => trans("admin.warehouses.validations.name_en_required"),
            "name_en.string" => trans("admin.warehouses.validations.name_en_string"),
            "name_en.min" => trans("admin.warehouses.validations.name_en_min"),
            "torod_warehouse_name.required" => trans("admin.warehouses.validations.torod_warehouse_name_required"),
            "administrator_name.required" => trans("admin.warehouses.validations.administrator_name_required"),
            "administrator_phone.required" => trans("admin.warehouses.validations.administrator_phone_required"),
            "administrator_email.required" => trans("admin.warehouses.validations.administrator_email_required"),
            "map_url.required" => trans("admin.warehouses.validations.map_url_required"),
            // "map_url.url" => trans("admin.warehouses.validations.map_url_url"),
            "latitude.required" => trans("admin.warehouses.validations.latitude_required"),
            "longitude.required" => trans("admin.warehouses.validations.longitude_required")
        ];
    }

    public function attributes()
    {
        return [
            "additional_unit_price" => "(".__("admin.warehouses.additional_unit_price").")",
            "package_covered_quantity" => "(".__("admin.warehouses.package_covered_quantity").")",
            "package_price" => "(".__("admin.warehouses.package_price").")",
            "countries" => "(".__("admin.warehouses.countries").")",
            "countries.*" => "(".__("admin.warehouses.countries").")",
            "api_key" => "(".__("admin.warehouses.api-key").")",
        ];
    }
}
