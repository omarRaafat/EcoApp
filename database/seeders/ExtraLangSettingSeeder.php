<?php

namespace Database\Seeders;

use App\Enums\SettingEnum;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtraLangSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Setting::create(['key'=> SettingEnum::terms_gr ,'value'=>'Willkommen bei den Allgemeinen Geschäftsbedingungen von Amazon Prime („Allgemeine Geschäftsbedingungen“).' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'الشروط و الاحكام بالالمانية']);
//        Setting::create(['key'=> SettingEnum::terms_fr ,'value'=>"Bienvenue dans les conditions générales d'Amazon Prime ('Conditions générales')." , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'الشروط و الاحكام بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::terms_id ,'value'=>'Selamat datang di Syarat dan Ketentuan Amazon Prime ("Syarat dan Ketentuan").' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'الشروط و الاحكام بالاندونيسية']);

//        Setting::create(['key'=> SettingEnum::working_time_gr ,'value'=>'Von Sonntag bis Donnerstag / von 8:00 - 16:00 Uhr', 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'مواعيد العمل بالالمانية']);
//        Setting::create(['key'=> SettingEnum::working_time_fr ,'value'=>'Du dimanche au jeudi / de 8h00 à 16h00', 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'مواعيد العمل بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::working_time_id ,'value'=>'Dari Minggu hingga Kamis / dari 8:00 - 16:00', 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'مواعيد العمل بالاندونيسية']);

//        Setting::create(['key'=> SettingEnum::address_gr ,'value'=>'Riada, Saudi-Arabien' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'العنوان بالالمانية']);
//        Setting::create(['key'=> SettingEnum::address_fr ,'value'=>'Riada, Riada, Arabie Saoudite' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'العنوان بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::address_id ,'value'=>'riada, Arab Saudi' , 'type' => 'contact_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'العنوان بالاندونيسية']);


//        Setting::create(['key'=> SettingEnum::site_name_gr ,'value'=>'saudische daten' , 'type' => 'site_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'اسم الموقع بالالمانية']);
//        Setting::create(['key'=> SettingEnum::site_name_fr ,'value'=>'dattes saoudiennes' , 'type' => 'site_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'اسم الموقع بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::site_name_id ,'value'=>'kurma saudi' , 'type' => 'site_info' , 'editable'=>1 ,'input_type'=>'string' , 'scope' =>'global' ,'desc'=>'اسم الموقع بالاندونيسية']);


//        Setting::create(['key'=> SettingEnum::seo_desc_gr ,'value'=>'Saudische Daten' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف محركات البحث بالالمانية']);
//        Setting::create(['key'=> SettingEnum::seo_desc_fr ,'value'=>'Dattes saoudiennes' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف محركات البحث بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::seo_desc_id ,'value'=>'Tanggal Saudi' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف محركات البحث بالاندونيسية']);


//        Setting::create(['key'=> SettingEnum::seo_keys_gr ,'value'=>'Saudische Daten, Daten' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'كلمات محركات البحث بالالمانية']);
//        Setting::create(['key'=> SettingEnum::seo_keys_fr ,'value'=>'Dattes saoudiennes, Dattes' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'كلمات محركات البحث بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::seo_keys_id ,'value'=>'Tanggal Saudi, Tanggal' , 'type' => 'site_info' , 'editable'=>0 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'كلمات محركات البحث بالاندونيسية']);


//        Setting::create(['key'=> SettingEnum::recipes_page_title_gr ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'عنوان صفحة الوصفات بالالمانية']);
//        Setting::create(['key'=> SettingEnum::recipes_page_title_fr ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'عنوان صفحة الوصفات بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::recipes_page_title_id ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'عنوان صفحة الوصفات بالاندونيسية']);


//        Setting::create(['key'=> SettingEnum::recipes_page_desc_gr ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف صفحة الوصفات بالالمانية']);
//        Setting::create(['key'=> SettingEnum::recipes_page_desc_fr ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف صفحة الوصفات بالفرنسية']);
//        Setting::create(['key'=> SettingEnum::recipes_page_desc_id ,'value'=>'' , 'type' => 'recipes', 'editable'=>1 ,'input_type'=>'text' , 'scope' =>'global' ,'desc'=>'وصف صفحة الوصفات بالاندونيسية']);



    }

}
