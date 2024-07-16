<?php
namespace App\Scopes;

use App\Enums\CustomHeaders;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
class ProductCountryScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Str::contains(Route::current()?->uri(), "api")) {
            $country = null;

            if (request()->hasHeader(CustomHeaders::COUNTRY_CODE)) {
                $code = request()->header(CustomHeaders::COUNTRY_CODE);
                $country = Country::with("warehouse")->code($code)->active()->first();
            }
            if (!$country) $country = Country::with("warehouse")->national()->first();

            $builder->whereHas('prices', fn($p) => $p->where('country_id', $country?->id))
            ->with([
                'productPriceCountry' => fn($p) => $p->where('country_id', $country?->id),
                'nationalCountryPrice',
                'warehouseStock' => fn($s) => $s->when(
                    $country && $country->warehouse->first(),
                    fn($sQuery) => $sQuery->warehouseId($country->warehouse->first()->id)
                )
            ]);
        }
    }
}
