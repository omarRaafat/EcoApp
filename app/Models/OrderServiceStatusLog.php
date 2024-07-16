<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderServiceStatusLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_service_id',
        'status',
        'created_by',
        'by_guard',
        'raison'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id','created_by')->withDefault();
    }

    public function orderService()
    {
        return $this->belongsTo(OrderService::class,'order_service_id');
    }
    #type of order
    public function orderType(){
        if($this->order_vendor_shipping_id){
            return 'شحنة بائع'. " #". $this->order_vendor_shipping_id;
        }
        return 'طلب رئيسي'. " #". $this->order_id;
    }
    #Type Of User
    public function userTypeLabel(){
        return $this->user->type ?? ((in_array($this->status,['waitingPay','paid','canceled'])) ? 'المزارع' : 'النظام');
    }
}
