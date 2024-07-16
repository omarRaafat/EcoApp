<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_vendor_shipping_id',
        'status',
        'created_by',
        'by_guard',
        'raison'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id','created_by')->withDefault();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    #نوع الطلب
    public function orderType(){
        if($this->order_vendor_shipping_id){
            return 'شحنة بائع'. " #". $this->order_vendor_shipping_id;
        }
        return 'طلب رئيسي'. " #". $this->order_id;
    }

    #نوع الفاعل
    public function userTypeLabel(){
        return $this->user->type ?? ((in_array($this->status,['waitingPay','paid','canceled'])) ? 'المزارع' : 'النظام');
    }

}
