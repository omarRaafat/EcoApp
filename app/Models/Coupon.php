<?php

namespace App\Models;

use App\Enums\CouponDiscountType;
use App\Enums\CouponStatus;
use App\Enums\CouponType;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Coupon extends BaseModel
{
    use HasTranslations, SoftDeletes;

    protected $fillable = [
        'title',
        'code',
        'amount',
        'minimum_order_amount',
        'maximum_discount_amount',
        'discount_type',
        'status',
        'start_at',
        'expire_at',
        'maximum_redemptions_per_user',
        'maximum_redemptions_per_coupon',
        'number_of_redemptions',
        'coupon_type',
        'duration_Type'
    ];

    protected $append = [
        'isExpired', 'isNotExpired', 'isStarted', 'isExceedMaxUsage',
    ];

    public $translatable = ['title'];
    public $casts = [
        'start_at' => 'date',
        'expire_at' => 'date'
    ];

    public function CouponMeta()
    {
        return $this->hasOne(CouponMeta::class,'coupon_id', 'id');
    }

    public function couponUser()
    {
        return $this->hasMany(CouponUser::class,'coupon_id');
    }

    public function couponUsers() {
        return $this->belongsToMany(
            Client::class,
            'coupon_user',
            'coupon_id',
            'user_id',
        );
    }

    public function checkifExpired()
    {
        if($this->expire_at == null) return false;
        return today() > $this->expire_at;
    }

    public function isStarted() : Attribute {
        return Attribute::make(
            get: fn () => !$this->start_at || Carbon::now() >= $this->start_at,
        );
    }

    public function isExpired() : Attribute {
        return Attribute::make(
            get: fn () => $this->checkifExpired(),
        );
    }

    public function isNotExpired() : Attribute {
        return Attribute::make(
            get: fn () => !$this->checkifExpired(),
        );
    }

    public function isExceedMaxUsage() : Attribute {
        return Attribute::make(
            get: fn () => $this->number_of_redemptions >= $this->maximum_redemptions_per_coupon,
        );
    }

    public function isActive() : Attribute {
        return Attribute::make(
            get: fn () => $this->status == CouponStatus::APPROVED
        );
    }

    public function amountInHalala() : Attribute {
        return Attribute::make(
            get: fn () => $this->amount * 100,
        );
    }

    public function maximumDiscountAmountInHalala() : Attribute {
        return Attribute::make(
            get: fn () => $this->maximum_discount_amount * 100,
        );
    }

    // TODO: Delete
    public function isExceedCustomerMaxUsage(int $customer_id)
    {
        return  ($this->maximum_redemptions_per_user != null) &&
        $this->couponUser()->where('user_id',$customer_id)->count() >= $this->maximum_redemptions_per_user;
    }

    // TODO: Delete
    public function isMinimumAcceptable($total)
    {
        return ($this->minimum_order_amount == null) || ($this->minimum_order_amount * 100) <= $total;
    }

    // TODO: Delete
    public function calculateDiscount($total)
    {
        $discountValue = 0;
        switch ($this->discount_type) {
            case CouponDiscountType::FIXED:
                $discountValue = $this->amount * 100; // convert to halala
            break;

            case CouponDiscountType::PERCENTAGE:
                $discountValue = ($this->amount * $total) /100; // will be in halala according to the total which is sent as halala too
            break;
            default:
                 // To-Do Throw Error
            break;
        }

        if ($this->maximum_discount_amount && $discountValue > ($this->maximum_discount_amount * 100)) {
            $discountValue = $this->maximum_discount_amount * 100; // convert to halala
        }
        // just make sure in case discount value graeter than total (free transaction)
        return $discountValue > $total ? $total : $discountValue;
    }

    // TODO: Delete
    /**
     * @param float $totalInHalala
     * @return bool
     * @throws Exception // @todo need to be refactored
     */
    public function isValidToUse(float $totalInHalala) : bool {
        if (!$this->is_started) {// not started
            throw new Exception(__("cart.api.coupon-not-started", ['date' => $this->start_at]));
        }

        if ($this->is_expired) {// expired
            throw new Exception(__("cart.api.coupon-expired"));
        }

        if (!$this->is_active) {// not active
            throw new Exception(__("cart.api.coupon-not-active"));
        }

        if ($this->is_exceed_max_usage) {// exceed maximum limit
            throw new Exception(__("cart.api.coupon-exceed-usage"));
        }

        if ($this->coupon_type == CouponType::GLOBAL && !$this->isMinimumAcceptable($totalInHalala)) {
            throw new Exception(__("cart.api.coupon-missed-order-minimum"));
        }

        if ($this->coupon_type == CouponType::FREE && !$this->isMinimumAcceptable($totalInHalala)) {
            throw new Exception(__("cart.api.coupon-missed-delivery-minimum"));
        }
        return true;
    }


    public function scopeAvailabe($query, $cart){
        return $query->where('status',CouponStatus::APPROVED)
        ->whereColumn('number_of_redemptions','<','maximum_redemptions_per_coupon')
        ->whereDate('start_at','<=',Carbon::now()->toDateString())
        ->whereDate('expire_at','>=',Carbon::now()->toDateString())
        ->where(function($qr) use($cart){
            $qr->where('minimum_order_amount','<=', $cart->total)
                ->orWhere('minimum_order_amount',null);
        })
        ->where(function($qr) use($cart){
            $qr->where('maximum_redemptions_per_user','>', $this->couponUser()->where('user_id', $cart->user_id)->count())
                ->orWhere('maximum_redemptions_per_user',null);
        });
        
    }

}
