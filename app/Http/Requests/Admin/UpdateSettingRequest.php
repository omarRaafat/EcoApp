<?php

namespace App\Http\Requests\Admin;

use App\Enums\SettingEnum;
use Illuminate\Foundation\Http\FormRequest;
class UpdateSettingRequest extends FormRequest
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
//            "site_name_en" => SettingEnum::getKeyValidation(   SettingEnum::site_name_en ),
//            "site_name_fr" => SettingEnum::getKeyValidation(   SettingEnum::site_name_en ),
//            "site_name_gr" => SettingEnum::getKeyValidation(   SettingEnum::site_name_en ),
//            "site_name_id" => SettingEnum::getKeyValidation(   SettingEnum::site_name_en ),

            // "seo_desc" => SettingEnum::getKeyValidation(   SettingEnum::seo_desc ),
            // "seo_keys" => SettingEnum::getKeyValidation(   SettingEnum::seo_keys ),
//            "recipes_page_desc_en" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_desc_en ),
//            "recipes_page_desc_gr" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_desc_en ),
//            "recipes_page_desc_id" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_desc_en ),
//            "recipes_page_desc_fr" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_desc_en ),

//            "recipes_page_title_en" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_title_en ),
//            "recipes_page_title_id" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_title_en ),
//            "recipes_page_title_fr" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_title_en ),
//            "recipes_page_title_gr" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_title_en ),

//            "working_time_en" => SettingEnum::getKeyValidation(   SettingEnum::working_time_en ),
//            "working_time_id" => SettingEnum::getKeyValidation(   SettingEnum::working_time_en ),
//            "working_time_fr" => SettingEnum::getKeyValidation(   SettingEnum::working_time_en ),
//            "working_time_gr" => SettingEnum::getKeyValidation(   SettingEnum::working_time_en ),

//            "terms_ar" => SettingEnum::getKeyValidation(   SettingEnum::terms_ar ),
//            "terms_en" => SettingEnum::getKeyValidation(   SettingEnum::terms_en ),
//            "terms_id" => SettingEnum::getKeyValidation(   SettingEnum::terms_en ),
//            "terms_gr" => SettingEnum::getKeyValidation(   SettingEnum::terms_en ),
//            "terms_fr" => SettingEnum::getKeyValidation(   SettingEnum::terms_en ),

            //            'delivery_price' => 'required',
//            'returnShipment' => 'required',
//            'min_diposit' => 'required',
//            'max_diposit' => 'required',
//            'vendor_min' => 'required',
//            'fuelprice' => 'required',
//            'shipmentmaxqnt' => 'required',
//            'shipmentmaxqnt_price' => 'required',



//            "recipes_book" => SettingEnum::getKeyValidation(   SettingEnum::recipes_book ),
            "site_logo" => SettingEnum::getKeyValidation(   SettingEnum::site_logo ),
            "browser_logo" => SettingEnum::getKeyValidation(   SettingEnum::browser_logo ),
            "footer_logo" => SettingEnum::getKeyValidation(   SettingEnum::footer_logo ),
            "footer_logo2" => SettingEnum::getKeyValidation(   SettingEnum::footer_logo2 ),
            "vendor_login_page" => ['required','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            "mouzare_link" => ['required','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            "vendor_terms" => SettingEnum::getKeyValidation(SettingEnum::vendor_terms),
            "facebook" =>  SettingEnum::getKeyValidation(   SettingEnum::facebook ),
            "instagram" => SettingEnum::getKeyValidation(   SettingEnum::instagram ),
            "twitter" => SettingEnum::getKeyValidation(   SettingEnum::twitter ),
            "site_name" => SettingEnum::getKeyValidation(   SettingEnum::site_name ),

            "phone" => SettingEnum::getKeyValidation(   SettingEnum::phone ),
            "whatsapp" => SettingEnum::getKeyValidation(   SettingEnum::whatsapp ),
            "email" => SettingEnum::getKeyValidation(   SettingEnum::email ),
            "address" => SettingEnum::getKeyValidation(   SettingEnum::address ),
            "working_time" => SettingEnum::getKeyValidation(   SettingEnum::working_time ),
//            "recipes_page_title" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_title ),
//            "recipes_page_desc" => SettingEnum::getKeyValidation(   SettingEnum::recipes_page_desc ),
            "vat" => SettingEnum::getKeyValidation(   SettingEnum::vat ),
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
            'recipes_book.mimes' => trans('admin.settings.validations.pdf'),

        ];
    }
}
