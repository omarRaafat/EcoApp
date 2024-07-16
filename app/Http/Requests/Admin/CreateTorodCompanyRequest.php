<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateTorodCompanyRequest extends FormRequest
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
            'name_ar' => ["required", "string", "min:3", "max:250"],
            'name_en' => ["required", "string", "min:3", "max:250"],
            'desc_ar' => ["nullable", "string", "min:3", "max:250"],
            'desc_en' => ["nullable", "string", "min:3", "max:250"],
            'delivery_fees' => ["required", "numeric"],
            'domestic_zone_id' => ["required"],
            'torod_courier_id' => ["required", "unique:torod_companies,torod_courier_id"],
            "logo" => ["image", "mimes:jpeg,png,jpg,gif,svg|max:2048"]
            
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
            "name_ar.required" => trans("admin.torodCompanies.validations.name_ar_required"),
            "name_ar.string" => trans("admin.torodCompanies.validations.name_ar_string"),
            "name_ar.min" => trans("admin.torodCompanies.validations.name_ar_min"),
            "name_en.required" => trans("admin.torodCompanies.validations.name_en_required"),
            "name_en.string" => trans("admin.torodCompanies.validations.name_en_string"),
            "name_en.min" => trans("admin.torodCompanies.validations.name_en_min"),
            // "desc_ar.required" => trans("admin.torodCompanies.validations.desc_ar_required"),
            "desc_ar.string" => trans("admin.torodCompanies.validations.desc_ar_string"),
            "desc_ar.min" => trans("admin.torodCompanies.validations.desc_ar_min"),
            // "desc_en.required" => trans("admin.torodCompanies.validations.desc_en_required"),
            "desc_en.string" => trans("admin.torodCompanies.validations.desc_en_string"),
            "desc_en.min" => trans("admin.torodCompanies.validations.desc_en_min"),
            "active_status.boolean" => trans("admin.torodCompanies.validations.active_status_boolean"),
            "delivery_fees.required" => trans("admin.torodCompanies.validations.delivery_fees_required"),
            "delivery_fees.numeric" => trans("admin.torodCompanies.validations.delivery_fees_numeric"),
            "domestic_zone_id.required" => trans("admin.torodCompanies.validations.domestic_zone_id_required"),
            "torod_courier_id.required" => trans("admin.torodCompanies.validations.torod_courier_id_required"),
            "torod_courier_id.unique" => trans("admin.torodCompanies.validations.torod_courier_id_unique"),
            "logo.image" => trans("admin.torodCompanies.validations.logo_image"),
            "logo.mimes" => trans("admin.torodCompanies.validations.logo_mimes"),
            "logo.max" => trans("admin.torodCompanies.validations.logo_max"),
        ];
    }

    /**
     * Array of attributes.
     *
     * @return array
     */
    public function attributes() : array
    {
        return [
            "name_ar" => trans("admin.torodCompanies.name_ar"),
            "name_en" => trans("admin.torodCompanies.name_en"),
            "desc_ar" => trans("admin.torodCompanies.desc_ar"),
            "desc_en" => trans("admin.torodCompanies.desc_en"),
            "active_status" => trans("admin.torodCompanies.active_status"),
            "delivery_fees" => trans("admin.torodCompanies.delivery_fees"),
            "domestic_zone_id" => trans("admin.torodCompanies.domestic_zone_id"),
            "torod_courier_id" => trans("admin.torodCompanies.torod_courier_id"),
            "logo" => trans("admin.torodCompanies.logo")
        ];
    }
}
