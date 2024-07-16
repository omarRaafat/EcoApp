<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckCityAndCityTDExistRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int    $city_id
 * @property int    $city_to_id
 * @property float  $dyna
 * @property float  $lorry
 * @property float  $truck
 *
 */
class LineShippingPriceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city_id'       => ['required','exists:cities,id' , new CheckCityAndCityTDExistRule(request()->city_to_id)],
            'city_to_id'    => ['required','exists:cities,id' , new CheckCityAndCityTDExistRule(request()->city_id)],
            'dyna'          => 'required',
            'lorry'         => 'required',
            'truck'         => 'required',
        ];
    }
}
