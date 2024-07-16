<?php
namespace App\Enums;

class SettingEnum {
    const vat = 'vat';
    const terms_ar = 'terms_ar';
    const terms_id = 'terms_id';
//    const terms_fr = 'terms_fr';
//    const terms_gr = 'terms_gr';
//    const terms_en = 'terms_en';
    const phone = 'phone';
    const whatsapp = 'whatsapp';
    const email = 'email';
    const address = 'address';
//    const address_en = 'address_en';
    const address_id = 'address_id';
//    const address_fr = 'address_fr';
//    const address_gr = 'address_gr';
    const working_time = 'working_time';
//    const working_time_en = 'working_time_en';
    const working_time_id = 'working_time_id';
//    const working_time_gr = 'working_time_gr';
//    const working_time_fr = 'working_time_fr';
    const facebook = 'facebook';
    const instagram = 'instagram';
    const twitter = 'twitter';
    const site_name = 'site_name';
//    const site_name_en = 'site_name_en';
    const site_name_id = 'site_name_id';
//    const site_name_fr = 'site_name_fr';
//    const site_name_gr = 'site_name_gr';
    const seo_desc = 'seo_desc';
//    const seo_desc_en = 'seo_desc_en';
    const seo_desc_id = 'seo_desc_id';
//    const seo_desc_fr = 'seo_desc_fr';
//    const seo_desc_gr = 'seo_desc_gr';
    const seo_keys = 'seo_keys';
//    const seo_keys_en = 'seo_keys_en';
//    const seo_keys_gr = 'seo_keys_gr';
//    const seo_keys_fr = 'seo_keys_fr';
    const seo_keys_id = 'seo_keys_id';

    const site_logo = 'site_logo';
    const browser_logo = 'browser_logo';
    const footer_logo = 'footer_logo';
    const footer_logo2 = 'footer_logo2';
    const recipes_book = 'recipes_book';
    const recipes_page_desc = 'recipes_page_desc';
//    const recipes_page_desc_en = 'recipes_page_desc_en';
    const recipes_page_desc_id = 'recipes_page_desc_id';
//    const recipes_page_desc_fr = 'recipes_page_desc_fr';
//    const recipes_page_desc_gr = 'recipes_page_desc_gr';
    const recipes_page_title = 'recipes_page_title';
//    const recipes_page_title_en = 'recipes_page_title_en';
    const recipes_page_title_id = 'recipes_page_title_id';
//    const recipes_page_title_fr = 'recipes_page_title_fr';
//    const recipes_page_title_gr = 'recipes_page_title_gr';

    const vendor_login_page = 'vendor_login_page';
    const vendor_terms = 'vendor_terms';
    const mouzare_link = 'mouzare_link';


//    const delivery_price = 'delivery_price';
//    const returnShipment = 'returnShipment';
//    const min_diposit = 'min_diposit';
//    const max_diposit = 'max_diposit';
    const vendor_min = 'vendor_min';
//    const fuelprice = 'fuelprice';

//    const shipmentmaxqnt = 'shipmentmaxqnt';
//    const shipmentmaxqnt_price = 'shipmentmaxqnt_price';

    const secret_wallet_key = 'secret_wallet_key';



    public static function getKeyValidation(string $key) : string|array|null {
        switch($key) {
            case self::vat:
                return "required|min:0|max:100|numeric";

//            case self::delivery_price:
//                return "required|min:0|max:100|numeric";
//            case self::returnShipment:
//                return "required|min:0|max:100|numeric";
//            case self::min_diposit:
//                return "required|min:0|max:100|numeric";
//            case self::max_diposit:
//                return "required|min:0|max:100|numeric";
//            case self::vendor_min:
//                return "required|min:0|max:100|numeric";
//            case self::fuelprice:
//                return "required|min:0|max:100|numeric";
//            case self::shipmentmaxqnt:
//                return "required|min:0|max:100|numeric";
//            case self::shipmentmaxqnt_price:
//                return "required|min:0|max:100|numeric";

            case self::facebook:
            case self::instagram:
            case self::twitter:
            case self::site_name:
//            case self::site_name_en:
            case self::site_name_id:
//            case self::site_name_fr:
//            case self::site_name_gr:

            case self::vendor_login_page:
            case self::mouzare_link:
            case self::address:
//            case self::address_en:
            case self::address_id:
//            case self::address_fr:
//            case self::address_gr:
                return "required|string|min:3|max:190";
            case self::terms_ar:
//            case self::terms_en:
            case self::terms_id:
//            case self::terms_fr:
//            case self::terms_gr:
            case self::vendor_terms:
                return "required|string|min:3|max:20000";
            case self::working_time:
//            case self::working_time_en:
            case self::working_time_id:
//            case self::working_time_fr:
//            case self::working_time_gr:
            case self::seo_desc:
//            case self::seo_desc_en:
//            case self::seo_desc_fr:
//            case self::seo_desc_gr:
            case self::seo_desc_id:
            case self::seo_keys:
//            case self::seo_keys_en:
            case self::seo_keys_id:
//            case self::seo_keys_fr:
//            case self::seo_keys_gr:
//            case self::recipes_page_desc_en:
            case self::recipes_page_desc_id:
//            case self::recipes_page_desc_fr:
//            case self::recipes_page_desc_gr:
            case self::recipes_page_desc:
            case self::recipes_page_title:
//            case self::recipes_page_title_en:
//            case self::recipes_page_title_fr:
//            case self::recipes_page_title_gr:
                return "required|string|min:3|max:1400";
            case self::phone:
                return [
                    "required",
//                    "regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/"
                ];
            case self::whatsapp:
                return [
                    "required",
//                    "regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/"
                ];
            case self::email:
                return "required|email|max:190";
            case self::site_logo:
            case self::browser_logo:
            case self::footer_logo:
            case self::footer_logo2:
                return "image|max:2048";
            case self::recipes_book:
                return "mimes:pdf|max:4096";
        }
        return null;
    }
}
