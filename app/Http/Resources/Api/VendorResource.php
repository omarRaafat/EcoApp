<?php

namespace App\Http\Resources\Api;

use App\Models\CartVendorShipping;
use App\Models\Product;
use App\Models\ShippingType;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property Product $cartProducts
 * @property Warehouse $warehousesReceive
 */
class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $vendor_id = $this->id;
        $vendorShippingTypes = ShippingType::query()->orderBy('title', 'desc')->whereHas('warehouses', function ($q) use ($vendor_id) {
            $q->where('vendor_id', $vendor_id);
        })->get();
        $shippingVendor = CartVendorShipping::where('cart_id', $this->pivot->cart->id)->where('vendor_id', $this->id)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'products' => CartProductsResourceCollection::make($this->cartProducts)->cart($this->pivot->cart)->vendor($this),
            'warehouses' => WarehouseResource::collection($this->warehouses),
            'receive_warehouses' => WarehouseResource::collection($this->warehousesReceive),
            'vendor_shipping_types' => ShippingTypeResource::collection($vendorShippingTypes),
            'totalShippingFees' => $this->getShippingFeesAndVanType($this->pivot->cart->id),
            'shipping_type_id' => $shippingVendor?->shipping_type_id,
            'shipping_method_id' => $shippingVendor?->shipping_method_id,
            'total_weight' => $shippingVendor?->total_weight,
        ];
    }
}
