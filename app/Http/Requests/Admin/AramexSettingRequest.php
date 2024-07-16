<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AramexSettingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'delivery_price' => 'required',
            'returnShipment' => 'required',
            'min_diposit' => 'required',
            'max_diposit' => 'required',
            'vendor_min' => 'required',
            'fuelprice' => 'required',
            'shipmentmaxqnt' => 'required',
            'shipmentmaxqnt_price' => 'required',
        ];
    }
}
