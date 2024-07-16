<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int        $id
 * @property string     $name
 * @property string     $torod_warehouse_name
 * @property string     $administrator_name
 * @property string     $administrator_phone
 * @property string     $administrator_email
 * @property string     $map_url
 * @property string     $latitude
 * @property string     $longitude
 * @property double     $package_price
 * @property int        $package_covered_quantity
 * @property double     $additional_unit_price
 * @property string     $address
 * @property string     $api_key
 * @property array      $mapType
 * @property resource   $shippingTypes
 * @property resource   $cities
 */
class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'torod_warehouse_name'      => $this->torod_warehouse_name,
            'administrator_name'        => $this->administrator_name,
            'administrator_phone'       => $this->administrator_phone,
            'administrator_email'       => $this->administrator_email,
            'map_url'                   => $this->map_url,
            'latitude'                  => $this->latitude,
            'longitude'                 => $this->longitude,
            'package_price'             => $this->package_price,
            'package_covered_quantity'  => $this->package_covered_quantity,
            'additional_unit_price'     => $this->additional_unit_price,
            'address'                   => $this->address,
            'api_key'                   => $this->api_key,
            'shipping_types'            => ShippingTypeResource::collection($this->shippingTypes),
            'cities'                    => CityResource::collection($this->cities),
        ];
    }
}
