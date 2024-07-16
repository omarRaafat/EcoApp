<?php

namespace App\Http\Controllers\Api;

use App\Enums\CustomHeaders;
use App\Http\Requests\Api\DeleteCartProduct;
use App\Models\Cart;
use Illuminate\Support\Str;
use App\Models\GuestCustomer;
use Illuminate\Http\Response;
use App\Http\Requests\Api\EditCartProduct;
use App\Http\Resources\Api\CartResource;
use App\Models\Address;
use App\Models\GuestCart;
use App\Models\Product;
use App\Services\Order\OrderProcess;

class GuestController extends ApiController
{
    public function __construct()
    {
        $this->middleware('api.guest-customer')->except(['generateToken', 'refreshToken']);
    }

    public function generateToken() {
        $headerToken = request()->header(CustomHeaders::GUEST_TOKEN, "");
        $token = $this->getTokenFromDb($headerToken);
        return $this->setApiResponse(true, Response::HTTP_OK, ['token' => $token], 'success');
    }

    public function refreshToken() {
        $token = $this->getTokenFromDb(request()->get("token", ""));
        return $this->setApiResponse(true, Response::HTTP_OK, ['token' => $token], 'success');
    }

    private function getTokenFromDb(string $token = "") : string {
        if (!$token) $token = GuestCustomer::create(['token' => Str::random(8)])->token;
        else {
            $token = GuestCustomer::fetchToken($token)->first()?->token;
            if (!$token) $token = GuestCustomer::create(['token' => Str::random(8)])->token;
        }
        return $token;
    }

    // TODO: this block need to be refactored
    public function editCart(EditCartProduct $request) {
        $guestCustomer = $request->get('guestCustomer');
        $product = Product::find($request->product_id);
        if (!$product || ($product && $product->is_not_available_product)) {
            return $this->setApiResponse(
                true, Response::HTTP_NOT_ACCEPTABLE, [], __('cart.api.cannot_checkout_product_missing')
            );
        }

        $cart = $guestCustomer->guestCart;
        if (!$cart) $cart = $guestCustomer->guestCart()->create();

        $cartProduct = $cart->cartProducts()->where(['product_id' => $product->id])->first();
        if ($cartProduct) {
            if ($request->quantity <= 0) $cartProduct->delete();
            else $cartProduct->update(['quantity' => $request->quantity]);
        } else if ($request->quantity > 0) {
            $cartProduct = $cart->cartProducts()->create([
                'quantity' => $request->quantity,
                'product_id' => $product->id,
                'vendor_id' => $product->vendor_id,
            ]);
        }

        $newCart = $this->getCartWithRelation($cart);

        if ($newCart && $newCart->vendors?->isNotEmpty())
            return $this->setApiResponse(
                true, Response::HTTP_OK, new CartResource($newCart), __('cart.api.cart_updated')
            );
        return $this->emptyCartResponse();
    }

    public function cartProducts() {
        $guestCustomer = request()->get('guestCustomer');
        $cart = $guestCustomer->guestCart;

        if ($cart && $newCart = $this->getCartWithRelation($cart)) {
            if ($newCart->vendors?->isNotEmpty()) {
                return $this->setApiResponse(
                    true,
                    Response::HTTP_OK,
                    new CartResource($newCart),
                    __('cart.api.cart_updated')
                );
            }
        }
        return $this->emptyCartResponse();
    }

    public function deleteCart(DeleteCartProduct $request) {
        $guestCustomer = request()->get('guestCustomer');
        $cart = $guestCustomer->guestCart;
        if ($cart) {
            $cart->cartProducts()->where('product_id', $request->product_id)->delete();

            $newCart = $this->getCartWithRelation($cart);

            if ($newCart && $newCart->vendors?->isNotEmpty()) {
                return $this->setApiResponse(
                    true, Response::HTTP_OK, new CartResource($newCart), __('cart.api.cart_updated')
                );
            }
        }
        return $this->emptyCartResponse();
    }

    private function getCartWithRelation(GuestCart $cart) : ?GuestCart {
        $cart->load(['cartProducts.product']);

        $newCart = GuestCart::where('id', $cart->id)
        ->with([
            'vendors' => fn($vQuery) => $vQuery->select('vendors.id', 'vendors.name')
                ->groupBy('vendors.id', 'vendors.name', 'guest_cart_products.guest_cart_id', 'guest_cart_products.vendor_id')
                ->with([
                    'guestCartProducts' => fn($cpQuery) => $cpQuery->where('guest_cart_products.guest_cart_id',$cart->id)
                ]),
            'products'
        ])
        ->withSum('cartProducts', 'quantity')
        ->first();

        $newCart->vendors = $newCart->vendors->map(function($v) {
            $v->cartProducts = $v->guestCartProducts;
            return $v;
        });

        $newCart->totals = (new OrderProcess($this->fromGuestCartToCart($newCart), request()))
            ->getCalculatorComponent()
            ->getTransactionTotalsInHalala();
        return $newCart;
    }

    private function emptyCartResponse() {
        return $this->setApiResponse(true, Response::HTTP_OK, [], __('cart.api.cart_is_empty'));
    }

    private function fromGuestCartToCart(GuestCart $cart) : Cart {
        $newCart = new Cart;
        $newCart->user_id = $cart->user_id;
        $newCart->vendors = $cart->vendors;
        $newCart->cartProducts = $cart->cartProducts;
        $newCart->products = $cart->products;
        $newCart->cart_products_sum_quantity = $cart->cart_products_sum_quantity;
        return $newCart;
    }
}
