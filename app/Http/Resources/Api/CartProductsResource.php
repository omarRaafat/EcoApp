<?php

namespace App\Http\Resources\Api;

use App\Models\CartProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductsResource extends JsonResource
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

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product_in_cart = CartProduct::where('cart_id' , $this->cart?->id)->where('vendor_id' , $this->vendor?->id)->where('product_id' , $this->id)->first();
        // dd($product_in_cart?->warehouse->id);
        // $shippingType = CartProduct::where('cart_id' , $this->cart?->id)->where('vendor_id' , $this->vendor?->id)->where('product_id' , $this->id)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'image' => $this->square_image_small,
            'quantity'   => $this->pivot->quantity,
            'price' => $this->price_in_sar_rounded,
            'price_before_offer' => $this->price_before_offer_in_sar_rounded,
            'available' => ($this->deleted_at || ($this->is_active !=1 || $this->status !='accepted')? 0 : 1),
            'is_available' => $this->is_available_product,
            'warehouse' => $product_in_cart?->warehouse ? ['id' => $product_in_cart->warehouse?->id , 'name' => $product_in_cart->warehouse?->name] : null ,
            'shippingType' => $product_in_cart?->shippingType ? ['id' => $product_in_cart->shippingType?->id , 'name' => $product_in_cart->shippingType?->title] : null ,
            'total_weight'   => $product_in_cart?->total_weight,
            'shipping_fees'   => $product_in_cart?->shipping_fees,
            'total_weight_label' => $this?->total_weight_label,
        ];
    }
}
