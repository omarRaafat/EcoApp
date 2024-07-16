<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartProduct extends Pivot
{
    use HasFactory;

    protected $table = 'cart_product';

    protected $fillable=[ 'cart_id' , 'product_id', 'quantity',
    'vendor_id' , 'warehouse_id' , 'shipping_type_id' , 'shipping_fees' , 'total_weight' , 'has_line_shipping' , 'total_price','service_id','service_fields'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function services()
    {
        return $this->belongsTo(Service::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function service() :BelongsTo
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(warehouse::class , 'warehouse_id');
    }

    public function shippingType()
    {
        return $this->belongsTo(ShippingType::class , 'shipping_type_id');
    }
    public function cartProductServiceFields() : HasMany
    {
        return $this->hasMany(CartProductServiceField::class,'cart_product_id');
    }
    // pub totalShippingWeight(){
    //    return $this->cartProducts
    // }
}
