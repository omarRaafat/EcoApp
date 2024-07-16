<?php

namespace App\Http\Resources\Api;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\GuestCustomer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private function getCart(Request $request)
    {
        $auth = request()->header('X-Guest-Token');
        if(auth('api_client')->check())
            $auth = auth('api_client')->user()->id;
        else
            $guest = GuestCustomer::whereToken($auth)->first();
            if(auth('api_client')->user())
            {
                $cart = Cart::where('user_id', $auth)->withSum('cartProducts', 'quantity')->first();
                if (!$cart) $cart = Cart::create(['user_id' => $auth, 'is_active' => 1 , 'city_id' => request()->city_id] );
                else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);
                else if(request()->has('city_id')  && $cart->city_id != request()->get('city_id') )  $cart->update(['city_id' => request()->city_id]);
            }else{
                $cart = Cart::where('guest_customer_id', $guest->id)->withSum('cartProducts', 'quantity')->first();
                if (!$cart) $cart = Cart::create(['guest_customer_id' => $guest->id, 'is_active' => 1 , 'city_id' => request()->city_id] );
                else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);
                else if(request()->has('city_id')  && $cart->city_id != request()->get('city_id') )  $cart->update(['city_id' => $request->city_id]);
            }
            return $cart;
    }
    public function toArray($request)
    {
        $cart = $this->getCart($request);
        $cartProducts = CartProduct::where('vendor_id', $this->id)
            ->where('cart_id',$cart->id)
            ->whereNotNull('service_id')
            ->with('cartProductServiceFields')
            ->get();

        $services = $cartProducts->map(function($cartProduct) {
            return $cartProduct->service;
        })->unique('id');
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'services' => ServiceResource::collection($services),
            'services' => CartServiceDataResource::collection($cartProducts)
        ];
    }
}
