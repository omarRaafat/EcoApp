<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AvailableMethodsRequest;
use App\Http\Resources\Api\ShippingMethodResource;
use App\Models\City;
use App\Models\ShippingMethod;
use App\Services\Eportal\Connection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShippingMethodController extends ApiController
{

    /**
     * Shipping Method Controller Constructor.
     *
     */
    public function getAvailableMethods(AvailableMethodsRequest $request) {
        $city = $request->has('city_id') ? City::find($request->get('city_id')) : null;
        $methods = ShippingMethod::when(
            $city,
            function ($query) use ($city) {
                $query->whereHas('domesticZones', fn($zone) => $this->domesticZoneQuery($zone, $city));
            }
        )
        ->active()
        ->with(["domesticZones" => fn($zone) => $this->domesticZoneQuery($zone, $city)])
        ->get();

        return $this->setApiResponse(
            true,
            $methods->isEmpty() ? 422 : Response::HTTP_OK,
            ShippingMethodResource::collection($methods),
            $methods->isEmpty() ? __('api.address-out-of-coverage') : __('api.shipping_methods.retrived')
        );
    }

    private function domesticZoneQuery($zoneQuery, City $city) {
        return $zoneQuery->whereHas('cities', fn($c) => $c->where('cities.id', $city->id));
    }
}
