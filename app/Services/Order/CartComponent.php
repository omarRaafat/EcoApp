<?php
namespace App\Services\Order;

use App\Models\Cart;
use App\Models\GuestCustomer;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Scopes\ProductCountryScope;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use App\Models\Client;

class CartComponent {
    private Cart $cart;
    private int $cartId;

    public function __construct(Cart $cart) {
        $this->cart = $cart;
        if ($cart->id) {
            $this->cartId = $cart->id;
            $this->refreshCart();
        }
    }

    public function getCart() : Cart {
        return $this->cart;
    }

    public function refreshCart() {
        $this->cart = Cart::where('id' ,$this->cartId)->with([
            'vendors' => fn($vendorQuery) => $vendorQuery->select('vendors.id', 'vendors.name', 'vendors.commission')
                ->groupBy('vendors.id', 'vendors.name', 'vendors.commission', 'cart_product.cart_id', 'cart_product.vendor_id')
                ->with([
                    'cartProducts' => fn($cartProductQuery) => $cartProductQuery->where('cart_product.cart_id', $this->cart->id)->withTrashed()
                ]),
            'cartProducts.product',
            'user','guestCustomer'
        ])
        ->withSum('cartProducts','quantity')
        ->first();
    }

    public function getCustomer($type = Client::class){
        if($type == Client::class){
            return $this->cart->user;
        }elseif($type == GuestCustomer::class){
            return $this->cart->guestCustomer;
        }else{
            throw ValidationException::withMessages(['must be login to make checkout']);
       }

    }

    public function getProductsCount() : int {
        return $this->cart->products->count() ?? 0;
    }

    public function isProductsAvailable() : bool {
        try {
            $productCount = $this->getProductsCount();
            $availableProductCount = $this->cart->cartProducts->filter(fn($cartProduct) => $cartProduct->product->is_available_product)->count();
            return $availableProductCount == $productCount;
        } catch (Exception $e) {
            return false;
        }
    }

    public function isProductsHasStock() : bool {
        return $this->cart->cartProducts->filter(fn($cartProduct) => $cartProduct->quantity > ($cartProduct->product->stock ?? 0))->isEmpty();
    }

    public function isCartEmpty() : bool {
        return $this->cart->vendors->count() <= 0;
    }

    public function cartTotalWithoutVatInHalala() : float {
        return $this->cart->cartProducts->sum(fn($c) => $c->quantity * ($c->product?->price_without_vat_in_halala ?? 0));
    }

    public function cartTotalVatInHalala() : float {
        return $this->cart->cartProducts->sum(fn($c) => $c->quantity * ($c->product?->vat_rate_in_halala ?? 0));
    }

    public function cartTotalWeightInGram() : float {
        return $this->cart->cartProducts->sum(fn($cartProduct) => $cartProduct->quantity * ($cartProduct->product->total_weight ?? 0));
    }

    public function cartTotalQuantity() : int {
        return $this->cart->cartProducts->sum(fn($cartProduct) => $cartProduct->quantity);
    }

    public function vendorCartTotalWithoutVatInHalala(int $vendorId) : float {
        return $this->cart->cartProducts
            ->filter(fn($c) => $c->product->vendor_id == $vendorId)
            ->sum(fn($c) => $c->quantity * ($c->product?->price_without_vat_in_halala ?? 0));
    }

    public function vendorCartTotalVatInHalala(int $vendorId) : float {
        return $this->cart->cartProducts
            ->filter(fn($c) => $c->product->vendor_id == $vendorId)
            ->sum(fn($c) => $c->quantity * ($c->product?->vat_rate_in_halala ?? 0));
    }

    public function cartHasDifferentVatPercentage() : bool {
        return $this->cart->cartProducts->map(fn($c) => ['vat' => $c->product->vat_percentage])->groupBy('vat')->count() != 1;
    }

    public function firstVatPercentage() : float {
        return Setting::where('key' , 'vat')->first()->value ?? 0;
    }

    public function cartProductsMissedPrice() : Collection {
        $missedProductIds = $this->cart->cartProducts
            ->filter(fn($c) => is_null($c->product->price_country_id ?? null))
            ->map(fn($c) => $c->product_id)
            ->toArray();

        return Product::query()->withoutGlobalScope(ProductCountryScope::class)->whereIntegerInRaw('id', $missedProductIds)->get()
        ->map(fn($p) => ['id' => $p->id, 'name' => $p->name]);
    }

    public function cartProductsMissedStock() {
        return $this->cart->cartProducts->filter(function ($cartProduct) {
            return $cartProduct->quantity > ($cartProduct->product->stock ?? 0);
        })->map(function ($c) {
            return ['product_id' => $c->product_id, 'stock' => $c->product->stock ?? 0];
        })->toArray();
    }
}
