<?php

namespace Database\Seeders;

use App\Enums\SettingEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();
        Setting::create(['key'=> SettingEnum::vat ,'value'=>'15.00' , 'type' => 'vat' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global' ,'desc'=>'ضريبة القيمة المضافة']);
//        Setting::create(['key'=> SettingEnum::terms_ar ,'value'=>'حب بكم في الشروط والأحكام ("الشروط والأحكام") الخاصة بأمازون برايم.' , 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'الشروط و الاحكام بالعربية'] );
//        Setting::create(['key'=> SettingEnum::terms_en ,'value'=>'حب بكم في الشروط والأحكام ("الشروط والأحكام") الخاصة بأمازون برايم.' , 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'الشروط و الاحكام بالانجليزية'] );
        Setting::create(['key'=> SettingEnum::phone ,'value'=>'00 996 6000 5777' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'phone' , 'scope' =>'global'  ,'desc'=>'رقم التواصل(الدعم الفنى)']);
        Setting::create(['key'=> SettingEnum::email ,'value'=>'saudidates@gmail.com' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'email' , 'scope' =>'global' ,'desc'=>'البريد الالكتروني']);
        Setting::create(['key'=> SettingEnum::address ,'value'=>'الرياض، المملكة العربية السعودية' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'العنوان']);
//        Setting::create(['key'=> SettingEnum::address_en ,'value'=>'riada, KSA' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'العنوان بالانجليزية']);
        Setting::create(['key'=> SettingEnum::working_time ,'value'=>'من الأحد إلى الخميس / من الساعة 8:00 صباحاً - إلى الساعة 4:00 مساءاً', 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'مواعيد العمل بالعربية']);
//        Setting::create(['key'=> SettingEnum::working_time_en ,'value'=>'من الأحد إلى الخميس / من الساعة 8:00 صباحاً - إلى الساعة 4:00 مساءاً', 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'مواعيد العمل بالنجليزية']);
        Setting::create(['key'=> SettingEnum::facebook ,'value'=>'facebook.com' , 'type' => 'social_links' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'رابط فيسبوك']);
        Setting::create(['key'=> SettingEnum::instagram ,'value'=>'instagram.com' , 'type' => 'social_links' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'رابط انستجرام']);
        Setting::create(['key'=> SettingEnum::twitter ,'value'=>'twitter.com' , 'type' => 'social_links' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'رابط تويتر']);
        Setting::create(['key'=> SettingEnum::site_name ,'value'=>'منصة مزارع' , 'type' => 'site_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'اسم الموقع ']);
//        Setting::create(['key'=> SettingEnum::site_name_en ,'value'=>'saudi dates' , 'type' => 'site_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'اسم الموقع بالنجليزية']);
        Setting::create(['key'=> SettingEnum::seo_desc ,'value'=>'Saudi Dates' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف محركات البحث']);
//        Setting::create(['key'=> SettingEnum::seo_desc_en ,'value'=>'Saudi Dates' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف محركات البحث بالنجليزية']);
        Setting::create(['key'=> SettingEnum::seo_keys ,'value'=>'Saudi Dates, Dates' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'كلمات محركات البحث']);
//        Setting::create(['key'=> SettingEnum::seo_keys_en ,'value'=>'Saudi Dates, Dates' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'كلمات محركات البحث بالانجليزية']);
        Setting::create(['key'=> SettingEnum::site_logo ,'value'=>'images/settings/16768925647704.png' , 'type' => 'logo' , 'editable'=>1 ,'input_type'=>'image' , 'scope' =>'global' ,'desc'=>'لوجو الموقع']);
        Setting::create(['key'=> SettingEnum::browser_logo ,'value'=>'images/settings/16768965282496.webp' , 'type' => 'logo' , 'editable'=>1 ,'input_type'=>'image' , 'scope' =>'global' ,'desc'=>'لوجو المتصفح']);
        Setting::create(['key'=> SettingEnum::footer_logo ,'value'=>'images/settings/16768926273436.png' , 'type' => 'logo', 'editable'=>1 ,'input_type'=>'image' , 'scope' =>'global' ,'desc'=>'لوجو فوتر']);
        Setting::create(['key'=> SettingEnum::footer_logo2 ,'value'=>'images/settings/16768926274044.png' , 'type' => 'logo', 'editable'=>1 ,'input_type'=>'image' , 'scope' =>'global' ,'desc'=>'لوجو فوتر']);
//        Setting::create(['key'=> SettingEnum::recipes_book ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'pdf' , 'scope' =>'global' ,'desc'=>'لينك كتيب الوصفات']);
//        Setting::create(['key'=> SettingEnum::recipes_page_desc ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف صفحة الوصفات']);
//        Setting::create(['key'=> SettingEnum::recipes_page_desc_en ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف صفحة الوصفات بالانجلزية']);
//        Setting::create(['key'=> SettingEnum::recipes_page_title ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'عنوان صفحة الوصفات']);
////        Setting::create(['key'=> SettingEnum::recipes_page_title_en ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'عنوان صفحة الوصفات بالانجلزية']);
        Setting::create(['key'=> SettingEnum::vendor_login_page ,'value'=>'https://e-farmer.tasksa.dev/' , 'type' => 'vendor', 'editable'=> 1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'لينك واجهة التجار']);
        Setting::create(['key'=> SettingEnum::mouzare_link ,'value'=>'https://e-farmer.tasksa.dev/' , 'type' => 'vendor', 'editable'=> 1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'لينك بوابة مزارع']);
        Setting::create(['key'=> SettingEnum::vendor_terms ,'value'=>'الشروط' , 'type' => 'vendor', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'شروط و احكام التجار']);
        Setting::create(['key'=> SettingEnum::whatsapp ,'value'=>'00 996 6000 5776' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'phone' , 'scope' =>'global'  ,'desc'=>'رقم التواصل(الواتس أب)']);

        // Shipping price type
//        Setting::create(['key'=> SettingEnum::delivery_price ,'value'=>'34.5' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>'سعر التوصيل']);
//        Setting::create(['key'=> SettingEnum::returnShipment ,'value'=>'34.5' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>'سعر الرجيع']);
//        Setting::create(['key'=> SettingEnum::min_diposit ,'value'=>'50' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>' أقل سعر (ر.س.)']);
//        Setting::create(['key'=> SettingEnum::max_diposit ,'value'=>'2500' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>' اقصى سعر (ر.س)']);
//        Setting::create(['key'=> SettingEnum::vendor_min ,'value'=>'200' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>' أقل سعر للبائع (ر.س)']);
//        Setting::create(['key'=> SettingEnum::fuelprice ,'value'=>'5.00' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>'رسوم الوقود %']);
//        Setting::create(['key'=> SettingEnum::shipmentmaxqnt ,'value'=>'15' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>'الكمية الأقصى']);
//        Setting::create(['key'=> SettingEnum::shipmentmaxqnt_price ,'value'=>'1.5' , 'type' => 'shipping_price' , 'editable'=>1 ,'input_type'=>'numeric' , 'scope' =>'global'  ,'desc'=>'سعر بعد الكمية الأقصى']);

    }
}
