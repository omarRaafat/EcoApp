<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCountryPriceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_id'=> ["nullable", Rule::exists('products','id')],
            'country_id'=> ["required", Rule::exists('countries','id')->where('is_national',0)],
            "price_with_vat" => ["required","numeric","min:0.01","max:1000000"],
            "price_before_offer_in_halala" => ["nullable","numeric","min:0.01","max:1000000"],
        ];
    }

    public function attributes()
    {
        return [
            "country_id" => __("admin.countries_prices.country"),
            "price_with_vat" => __("translation.price") .' '. __('translation.sar'),
            "price_before_offer_in_halala" => __("translation.price_before_offer") .' '. __('translation.sar'),
        ];
    }
}
