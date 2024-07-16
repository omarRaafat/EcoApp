<?php

namespace App\Observers;

use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryObserver
{
    /**
     * Handle the Country "created" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function created(Country $country)
    {
        //
    }

    /**
     * Handle the Country "updated" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function updated(Country $country)
    {
        if ($country->isDirty("vat_percentage")) {
            $country->countryPrices()->update([
                "vat_percentage" => $country->vat_percentage,
                "vat_rate_in_halala" => DB::raw("price_without_vat_in_halala * ". ($country->vat_percentage / 100)),
                "price_with_vat_in_halala" => DB::raw("(price_without_vat_in_halala * ". ($country->vat_percentage / 100) ." + price_without_vat_in_halala)"),
            ]);
        }
    }

    /**
     * Handle the Country "deleted" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function deleted(Country $country)
    {
        //
    }

    /**
     * Handle the Country "restored" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function restored(Country $country)
    {
        //
    }

    /**
     * Handle the Country "force deleted" event.
     *
     * @param  \App\Models\Country  $country
     * @return void
     */
    public function forceDeleted(Country $country)
    {
        //
    }
}
