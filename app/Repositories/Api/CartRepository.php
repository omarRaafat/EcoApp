<?php

namespace App\Repositories\Api;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\GuestCustomer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Api\BaseRepository;
use App\Models\Client;

class CartRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return Cart::class;
    }

    /**
     * @param integer $customerId
     * @return Cart
     */
    public function curretUserCart(int $customerId , int $city_id = null, $type = Client::class) : Cart {
        if($type == Client::class){
            $cart = Cart::where('user_id', $customerId)->withSum('cartProducts', 'quantity')->first();
            if (!$cart) $cart = Cart::create(['user_id' => $customerId, 'is_active' => 1 , 'city_id' => $city_id] );
            else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);
            else if(request()->has('city_id')  && $cart->city_id != request()->get('city_id') )  $cart->update(['city_id' => $city_id]);

        }else{
            $cart = Cart::where('guest_customer_id', $customerId)->withSum('cartProducts', 'quantity')->first();
            if (!$cart) $cart = Cart::create(['guest_customer_id' => $customerId, 'is_active' => 1 , 'city_id' => $city_id] );
            else if ($cart->is_active != 1) $cart->update(['is_active' => 1]);
            else if(request()->has('city_id')  && $cart->city_id != request()->get('city_id') )  $cart->update(['city_id' => $city_id]);
        }
        return $cart;
    }

    public function createCartProduct(Model $cart,Array $cartProduct) : Model|bool
    {
        try {
            return CartProduct::updateOrCreate([
                    'cart_id' => $cart->id,
                    'product_id' => $cartProduct['product_id']
                ] ,
                $cartProduct
            );
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }
    public function createCartProductServices(Model $cart,Array $cartProduct) : Model|bool
    {
        // try {
            return CartProduct::updateOrCreate([
                    'cart_id' => $cart->id,
                    'service_id' => $cartProduct['service_id']
                ] ,
                $cartProduct
            );
        // } catch (\Illuminate\Database\QueryException $ex) {
        //     return false;
        // }
    }

    /**
     * @param CartProduct $cartProduct
     * @param Array $data
     * @return Model|boolean
     */
    public function editCartProduct(CartProduct $cartProduct,Array $data) : Model|bool
    {
        try {
            $cartProduct->update( $data);
            return $cartProduct;
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
    }

    /**
     * @param integer $product_id
     * @param integer $customerId
     * @return boolean
     */
    public function deleteCartProduct(int $product_id, int $customerId) : bool
    {
        try {
            $cart = $this->curretUserCart($customerId);
            if($cart) return $cart->cartProducts()->where('product_id',$product_id)->delete();
        } catch (\Illuminate\Database\QueryException $ex) {
            return false;
        }
        return false;
    }
}
