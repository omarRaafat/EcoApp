<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\Api\SettingService;
use  App\Http\Requests\Api\SendInqueryRequest;

class SettingController extends ApiController
{

    public function __construct(public SettingService $service) {
    }



    public function homePageSlider()
    {
        $settings  = $this->service->homePageSlider();
        return $this->setApiResponse(
            $settings['success'],
            $settings['status'],
            $settings['data'],
            $settings['message']
        );

    }

    public function websiteSetting()
    {
        $settings  = $this->service->websiteSetting();
        return $this->setApiResponse
        (
            $settings['success'],
            $settings['status'],
            $settings['data'],
            $settings['message']
        );

    }


    public function contactInfo()
    {
        $settings  = $this->service->contactInfo();
        return $this->setApiResponse
        (
            $settings['success'],
            $settings['status'],
            $settings['data'],
            $settings['message']
        );
    }


    public function mainData()
    {
        $settings  = $this->service->mainData();
        return $this->setApiResponse
        (
            $settings['success'],
            $settings['status'],
            $settings['data'],
            $settings['message']
        );
    }










}
