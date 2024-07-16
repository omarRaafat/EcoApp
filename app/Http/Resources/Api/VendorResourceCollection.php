<?php

namespace App\Http\Resources\Api;

use App\Models\Product;
use App\Models\ShippingType;
use App\Models\Warehouse;
use App\Models\WarehouseShippingType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property int        $id
 * @property string     $name
 * @property Product    $cartProducts
 * @property Warehouse  $warehousesReceive
 */
class VendorResourceCollection extends ResourceCollection
{

    protected $cart;

    public function cart($value){
        $this->cart = $value;
        return $this;
    }

    public function toArray($request){
        $data =  $this->collection->map(function(VendorResource $resource) use($request){
            return $resource->cart($this->cart)->toArray($request);
        })->all();

    }
}
