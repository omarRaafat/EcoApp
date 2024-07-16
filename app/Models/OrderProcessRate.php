<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProcessRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'order_id',
        'shipping_type_id',
        'merchantInteraction',
        'storeOrganization',
        'productAvailability',
        'orderArrivalSpeed',
        'deliveryRepInteraction',
        'productSafetyAfterDelivery',
        'repResponseTime',
    ];

    const CLMS_ARRAY = [
        'orderArrivalSpeed' => 'سرعة وصول الطلب',
        'deliveryRepInteraction' => 'تعامل مندوب التوصيل',
        'productSafetyAfterDelivery' => 'سلامة المنتجات بعد التوصيل',
        'repResponseTime' => 'وقت تواصل المندوب',
        'merchantInteraction' => 'تعامل التاجر',
        'storeOrganization' => 'ترتيب وتنظيم ونظافة المتجر',
        'productAvailability' => 'توفر المنتجات لدى التاجر  في الوقت المحدد للإستلام',
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class, "transaction_id");
    }

    public function order() {
        return $this->belongsTo(Order::class, "order_id");
    }

    
    public function shippingType(){
        return $this->belongsTo(ShippingType::class , 'shipping_type_id')->withDefault();
    }

    #متوسط التقييم 
    #If you modify here, ensure to modify scopeFilterAvgRating() accordingly.
    public function avgRating(){
        $ratings = [
            $this->merchantInteraction,
            $this->storeOrganization,
            $this->productAvailability,
        ];
        if($this->shipping_type_id == 2){
            $ratings = [
                $this->orderArrivalSpeed,
                $this->deliveryRepInteraction,
                $this->productSafetyAfterDelivery,
                $this->repResponseTime,
            ];
        }
        

        $total = array_sum($ratings);
    
        if ($total == 0) return 0;
        
        return round($total / count($ratings),2);
    }


    public function scopeFilterSearch($query){
        $query->when(request()->get('search'),function($qr){
            $qr->whereHas('transaction',function($qr2){
                $qr2->whereHas('customer',function($qr3){
                    $qr3->where('name','like','%'.request()->get('search').'%')->orWhere('phone','like',request()->get('search'));
                });
            })->orWhereHas('order',function($qr4){
                $qr4->whereHas('vendor',function($qr5){
                    $qr5->where('name->ar','like','%'.request()->get('search').'%');
                });
            });
        });
    }
    
    
    public function scopeFilterPeriod($query){
        $query->when(request()->get('from') && request()->get('to'),function($qr){
            $qr->whereBetween('created_at', [request()->get('from'), request()->get('to')]);        
        });
    }
    
    
    public function scopeFilterAvgRating($query){
        $query->when(request()->get('avgRatingFrom') && request()->get('avgRatingTo'),function($qr){
           if($this->shipping_type_id == 2){
            $qr->whereRaw('(orderArrivalSpeed + deliveryRepInteraction + productSafetyAfterDelivery + repResponseTime) / 4 BETWEEN ? AND ?', [request()->get('avgRatingFrom'), request()->get('avgRatingTo')]);        
            }else{
                $qr->whereRaw('(merchantInteraction + storeOrganization + productAvailability) / 3 BETWEEN ? AND ?', [request()->get('avgRatingFrom'), request()->get('avgRatingTo')]);        
           }
        });
    }

    public function scopeFilterShippingTypeId($query){
        $query->when(request()->get('shipping_type_id'),function($qr){
            $qr->where('shipping_type_id',request()->get('shipping_type_id') );        
        });
    }

    



}
