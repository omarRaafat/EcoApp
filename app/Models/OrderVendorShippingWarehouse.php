<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderVendorShippingWarehouse extends Model
{
    use HasFactory;

    protected $fillable=[ 
        'transaction_id',
        'order_ven_shipping_id' ,  'order_id','vendor_id' , 'product_id' , 'warehouse_id' , 'shipping_type_id' , 'shipping_method_id' , 'receive_order_code' , 'warehouse_city_id' ];

    public function orderVendorShipping(){
        return $this->belongsTo(OrderVendorShipping::class ,'order_ven_shipping_id');
    }

    public function order(){
        return $this->belongsTo(order::class ,'order_id');
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class ,'warehouse_id')->withDefault();
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class ,'vendor_id');
    }

    public function product(){
        return $this->belongsTo(Product::class ,'product_id');
    }
}
