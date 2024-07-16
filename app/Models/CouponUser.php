<?php

namespace App\Models;
class CouponUser extends BaseModel
{
    protected $table = 'coupon_user';
    
    protected $fillable = [
        'coupon_id', 'user_id'
    ];

    public function coupon() {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function customer() {
        return $this->belongsTo(Client::class, 'user_id');
    }
}