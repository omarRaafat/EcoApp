<?php
namespace App\Services\Api;

use App\Http\Resources\Api\SliderImageResource;
use App\Models\Setting;
use App\Models\Slider;
use App\Repositories\SettingRepository;
use App\Repositories\SliderRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class SettingService
{
    
    public function __construct(
        private SliderRepository $sliderRepository,
        private SettingRepository $settingRepository
    ) {}

    public function homePageSlider() {
        $sliders = Slider::descOrder()->get();

        if($sliders->isEmpty()) {
            return [
                'success' => false,
                'status' => Response::HTTP_OK,
                'data' => [],
                'message' => ''
            ];
        }

        return [
            'success' => true,
            'status' => Response::HTTP_OK,
            'data' => SliderImageResource::collection($sliders),
            'message' => ''
        ];
    }

    public function websiteSetting() {
        $settings = Setting::where('scope','global')->get()->pluck('value','key')->toArray();

        $data = [
            'browser_logo' =>  ossStorageUrl($settings['browser_logo'])?? "",
            'seo_desc' => (Config::get('app.locale') == 'ar' ) ? $settings['seo_desc'] : $settings['seo_desc_en'],
            'seo_keys' => (Config::get('app.locale') == 'ar' ) ? $settings['seo_keys'] : $settings['seo_keys_en'],
            'site_name' => (Config::get('app.locale') == 'ar' ) ? $settings['site_name'] : $settings['site_name_en'],
            'mouzare_link' => (Config::get('app.locale') == 'ar' ) ? $settings['mouzare_link'] : $settings['mouzare_link'],
        ];

        return [
            'success' => true ,
            'status' => 200 ,
            'data' =>  $data,
            'message' => __('api.settings.retrived')
        ];
    }

    public function contactInfo() {
        $settings = Setting::where('scope','global')->get()->pluck('value','key')->toArray();

        $info = [
            'phone' => $settings['phone'],
            'email' => $settings['email'],
            'facebook' => $settings['facebook'],
            'twitter' => $settings['twitter'],
            'instagram' => $settings['instagram'],
            'address' => (Config::get('app.locale') == 'ar')  ?  $settings['address'] : $settings['address_en'],
            'working_time' => (Config::get('app.locale') == 'ar') ? $settings['working_time'] : $settings['working_time_en'],
            'whatsapp' => isset($settings['whatsapp']) ? $settings['whatsapp'] : "",
        ];

        return [
            'success' => true ,
            'status' => 200 ,
            'data' => $info,
            'message' => __('api.settings.retrived')
        ];
    }

    public function mainData() {
        $settings = Setting::where('scope','global')->get()->pluck('value','key')->toArray();

        $info = [
            'vendor_login_page' => $settings['vendor_login_page'],
            'footer_logo' => ossStorageUrl($settings['footer_logo']),
            'footer_logo2' => ossStorageUrl($settings['footer_logo2']),
            'site_logo' => ossStorageUrl($settings['site_logo']),
            'facebook' => $settings['facebook'],
            'twitter' => $settings['twitter'],
            'instagram' => $settings['instagram'],
            'phone' => $settings['phone'],
            'email' => $settings['email'],
            'whatsapp' => isset($settings['whatsapp']) ? $settings['whatsapp'] : "",
        ];

        return [
            'success' => true ,
            'status' => 200 ,
            'data' =>  $info,
            'message' => __('api.settings.retrived')
        ];
    }
}

