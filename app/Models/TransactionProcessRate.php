<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionProcessRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'EaseSpeed', //سهولة وسرعة الوصول لمنصة مزارع
        'FreshnessInformation', // دقة وتوافق وحداثة المعلومات في منصة مزارع
        'EaseUse', // سهولة استخدام منصة مزارع من حيث سرعة التصفح والتنقل والتفاعل
        'ContactSupport' // فاعلية التواصل مع الدعم الفني وسرعة الإستجابة للشكاوى والإستفسارات
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class, "transaction_id");
    }

    #متوسط التقييم 
    #If you modify here, ensure to modify scopeFilterAvgRating() accordingly.
    public function avgRating(){
        $ratings = [
            $this->EaseSpeed,
            $this->FreshnessInformation,
            $this->EaseUse,
            $this->ContactSupport,
        ];
    
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
            $qr->whereRaw('(EaseSpeed + FreshnessInformation + EaseUse + ContactSupport) / 4 BETWEEN ? AND ?', [request()->get('avgRatingFrom'), request()->get('avgRatingTo')]);        
        });
    }

}
