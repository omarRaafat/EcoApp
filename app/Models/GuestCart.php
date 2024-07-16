<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
class GuestCart extends BaseModel
{
    protected $fillable = ['guest_id'];

    public function cartProducts()
    {
        return $this->hasMany(GuestCartProduct::class);
    }

    public function guest()
    {
        return $this->belongsTo(GuestCustomer::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'guest_cart_products', );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "guest_cart_products")
            ->withPivot('quantity','created_at','updated_at');
    }

    public function cartTotal() : Attribute {
        return Attribute::make(
            get: fn () => $this->products->sum(fn($p) => $p->price * $p->pivot->quantity),
        );
    }

    public function cartTotalInSar() : Attribute {
        return Attribute::make(
            get: fn () => $this->products->sum(fn($p) => $p->price * $p->pivot->quantity) / 100,
        );
    }

    public function  cartVendorShippings()
    {
        return $this->hasMany(CartVendorShipping::class , 'guest_cart_id');
    }

}
