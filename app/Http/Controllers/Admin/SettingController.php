<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AramexSettingRequest;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Client;

class SettingController extends Controller
{


    /**
     * @param SettingService $service
     */
    public function __construct(
        public SettingService $service,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->service->getAll();
        return view("admin.setting.form", compact('settings'));
    }

    public function edit($id) {
        $setting = $this->service->getSettingUsingID($id);
        $breadcrumbParent = 'admin.settings.index';
        $breadcrumbParentUrl = route('admin.settings.index');

        if (!$setting->editable) {
            Alert::error(__('admin.settings.messages.setting-not-editable'), __('admin.settings.messages.setting-not-editable'));
            return redirect(route('admin.settings.index'));
        }
        return view("admin.setting.edit", ['setting' => $setting, "breadcrumbParent" => $breadcrumbParent, "breadcrumbParentUrl" => $breadcrumbParentUrl]);
    }

    /**
     * Update the category..
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Redirect
     */
    public function update(UpdateSettingRequest $request)
    {

        // $setting = $this->service->getSettingUsingID($request);
        // if (!$setting->editable) {
        //     Alert::error(__('admin.settings.messages.setting-not-editable'), __('admin.settings.messages.setting-not-editable'));
        //     return redirect(route('admin.settings.index'));
        // }
        $customersCount = Client::count();
        $request_portal = $request->request->add(['count_customer_eportal' => $customersCount]);
        $result = $this->service->updateSetting($request);
        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }
        return redirect(route('admin.settings.index'));
    }

    public function aramex_settings()
    {
        $settings = $this->service->getAllAramexSetting('desc' , 'shipping_price');
        return view('admin.setting.aramex' , get_defined_vars());
    }

    public function aramex_settings_update(AramexSettingRequest $request)
    {
        $result = $this->service->updateSetting($request);
        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }
        return redirect(route('admin.settings.aramex.index'));
    }
}
