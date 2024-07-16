<?php

namespace App\Rules;

use App\Models\City;
use App\Models\DomesticZoneMeta;
use App\Models\DomesticZoneShippingMethod;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class CheckCityWithShippingMethodRule implements Rule
{
    private $request;
    private $msg ; 
    private $is_sync ; 

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        $this->msg = 'The validation error message.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (str_contains($attribute, 'vendors')) {
            $indexOfVendors = explode('.', $attribute)[2];
            $vendorRequest = $this->request['cart']['vendors'][$indexOfVendors];
        }
            $city = City::find($this->request['cart']['city_id']);
            $getDomesticIdsRelatedToShippingMethod = DomesticZoneShippingMethod::where('shipping_method_id' , $vendorRequest['shipping_method_id'])->pluck('domestic_zone_id')->toArray();
            $getDomesticIdDepandOnCity= DomesticZoneMeta::whereIn('domestic_zone_id' , $getDomesticIdsRelatedToShippingMethod)->where('related_model' , City::class)->where('related_model_id' , $city?->id)->first()?->domestic_zone_id;
            if(is_null($getDomesticIdDepandOnCity)){
                $this->msg = __('validation.shipping_doesnt_available');
                return false;
            }         
            
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}
