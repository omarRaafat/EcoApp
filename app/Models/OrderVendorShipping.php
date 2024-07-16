<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderVendorShipping extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'city_id' , 'to_city_id' ,'city_name' , 'to_city_name','shipping_type_id' ,  'van_type','total_shipping_fees' , 'total_weight' , 'vendor_id','order_id' ,'no_of_products' , 'user_id' , 'shipping_method_id' ,
        'base_shipping_fees' , 'extra_shipping_fees' , 'transaction_id' , 'status' , 'recieve_code' , 'is_accepted_shipping'
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }


    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function shippingType(){
        return $this->belongsTo(ShippingType::class , 'shipping_type_id')->withDefault();
    }

    public function shippingMethod(){
        return $this->belongsTo(ShippingMethod::class , 'shipping_method_id');
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class , 'transaction_id');
    }
    public function orderVendorWarehouses(){
        return $this->hasMany(OrderVendorShippingWarehouse::class , 'order_ven_shipping_id');
    }

    public function transShippingMethodStatus(int $shipping_method_id = null)
    {
        if($this->shipping_method_id == 1){
            return 'أرامكس';
        }
        elseif($this->shipping_method_id == 2){
            return 'سبل';
        }
    }

}
