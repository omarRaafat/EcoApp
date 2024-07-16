<?php

namespace App\Services\Api;

use App\Enums\CustomHeaders;
use App\Http\Resources\Api\SimpleCountry;
use App\Models\Country;
use App\Models\User;
use App\Scopes\ProductCountryScope;

class CountryService
{
    /**
     * @return array
     */
    public function getCountriesForDelivery(?User $customer) : array
    {
        $countryInHeader = request()->hasHeader(CustomHeaders::COUNTRY_CODE) && request()->header(CustomHeaders::COUNTRY_CODE) != '';

        $defaultCountry = Country::when(
            $countryInHeader, fn($q) => $q->where('code', request()->header(CustomHeaders::COUNTRY_CODE))
        )
        ->when(!$countryInHeader, fn($q) => $q->national())
        ->first();

        $countries = Country::whereHas(
                "countryPrices",
                function($priceQuery) {
                    $priceQuery->whereHas('product', fn($p) => $p->withoutGlobalScope(ProductCountryScope::class)->available());
                }
            )
            ->active()
            ->get()
            ->map(function($c) use ($defaultCountry, $customer) {
                $c->is_selected = ($customer ? $customer->country_id : ($defaultCountry ? $defaultCountry->id : null)) == $c->id;
                return $c;
            });
        return [
            'success' => true,
            'status' => 200 ,
            'data' => SimpleCountry::Collection($countries),
            'message' => __('api.countries.retrived')
        ];
    }

    /**
     * @param array $request
     * @return array
     */
    public function setCountryDeliveryToUser(array $request) : array {
        $user = auth('api')->user();

        $country = Country::where('code', $request['code'])->first();
        if($country && $user && $user instanceof User) $user->update(['country_id' => $country->id]);

        return [
            'success'=>true,
            'status'=>200 ,
            'data'=> [],
            'message'=>__('api.country_products_delivery_to')
        ];
    }

    public function getActiveGeoData()
    {
        // TODO: refactor is very important here, Related To Eng Ahmed Hesham
        return Country::with([
            "areas" => fn ($areaQ) => $areaQ->active()
                ->whereHas('cities', fn($cityQ) => $cityQ->active())
                ->with(['cities' => fn($cityQ) => $cityQ->active()])
        ])
            ->active()
            ->whereHas(
                'areas',
                fn($areaQ) => $areaQ->active()->whereHas(
                    'cities',
                    fn($cityQ) => $cityQ->active()
                )
            )
            ->get();
    }
}
