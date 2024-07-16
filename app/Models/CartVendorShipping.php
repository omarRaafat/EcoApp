<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartVendorShipping extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id' , 'to_city_id' ,'city_name' , 'to_city_name','shipping_type_id' ,'guest_customer_id',  'van_type','total_shipping_fees' , 'total_weight' , 'vendor_id','cart_id' , 
        'shipping_method_id' , 'delivery_warehouse_id',
        'user_id' , 'no_of_products' , 'extra_shipping_fees' , 'base_shipping_fees',
        'wallet_id', 'total_products'
    ];

    public function shippingMethod(){
        return $this->belongsTo(ShippingMethod::class , 'shipping_method_id');
    }


    public function to_city()
    {
        return $this->hasOne(City::class,'id','to_city_id');
    }

}
