<?php

namespace App\Models;

class GuestCartProduct extends BaseModel
{
    protected $fillable = [
        'guest_cart_id' , 'product_id', 'quantity', 'vendor_id' , 'total_price' , 'total_weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(GuestCart::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
