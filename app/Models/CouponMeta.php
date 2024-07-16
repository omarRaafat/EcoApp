<?php

namespace App\Models;
class CouponMeta extends BaseModel
{
    protected $fillable=['related_models','related_ids','coupon_id'];
    protected $casts = [
        'related_ids' => 'json'
    ];

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }
}
