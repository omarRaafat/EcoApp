<?php

namespace App\Http\Resources\Api;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property int        $id
 * @property string     $name
 * @property Product    $cartProducts
 * @property Warehouse  $warehousesReceive
 */
class CartProductsResourceCollection extends ResourceCollection
{

    protected $cart;
    protected $vendor;

    public function cart($value){
        $this->cart = $value;
        return $this;
    }

    public function vendor($value){
        $this->vendor = $value;
        return $this;
    }

    public function toArray($request){
        return $this->collection->map(function(CartProductsResource $resource) use($request){
            return $resource->cart($this->cart)->vendor($this->vendor)->toArray($request);
        })->all();
    }
}
