<?php
namespace App\Services\Order;

use App\Enums\CouponDiscountType;
use App\Enums\CouponType;
use App\Exceptions\Transactions\Coupons;
use App\Models\Coupon;
use Exception;

class DiscountComponent {
    private float $totalPaidAmountInHalala;

    public function __construct(
        private Coupon | null $coupon,
        float $totalPaidAmountInHalala,
        private int | null $customerId
    ) {
        $this->totalPaidAmountInHalala = $totalPaidAmountInHalala;
        $this->customerId = $customerId;
    }

    /**
     * @param float $totalPaidAmountInHalala
     * @param integer $customerId
     * @return float
     */
    public function getDiscount() : float {
        if (isset($this->coupon) && $this->coupon && $this->totalPaidAmountInHalala > 0) {
            try {
                $this->isValidToUse();
                if (
                    isset($this->customerId) &&
                    !is_null($this->customerId) &&
                    $this->isExceedCustomerMaxUsage($this->customerId)
                ) {// customer exceed maximum limit
                    throw new Coupons\CustomerUsageException;
                }
                return $this->calculateDiscountInHalala();
            } catch (Exception $e) {
                // TODO: ,must not ignore exceptions
            }
        }
        return 0;
    }

    public function getCoupon() : Coupon | null {
        return $this->coupon;
    }

    /**
     * @return float
     */
    public function calculateDiscountInHalala() : float {
        if (!isset($this->coupon) || !$this->coupon) return 0;
        $discountValueInHalala = 0;

        switch ($this->coupon->discount_type) {
            case CouponDiscountType::FIXED:
                $discountValueInHalala = $this->coupon->amount_in_halala;
            break;

            case CouponDiscountType::PERCENTAGE:
                $discountValueInHalala = ($this->coupon->amount * $this->totalPaidAmountInHalala) /100; // will be in halala according to the total which is sent as halala too
            break;
        }

        if (
            $this->coupon->maximum_discount_amount &&
            $discountValueInHalala > $this->coupon->maximum_discount_amount_in_halala
        ) {
            $discountValueInHalala = $this->coupon->maximum_discount_amount_in_halala;
        }

        // just make sure in case discount value graeter than total (free transaction)
        return $discountValueInHalala > $this->totalPaidAmountInHalala ? $this->totalPaidAmountInHalala : $discountValueInHalala;
    }

    /**
     * @return boolean
     * @throws Coupons\NotExistsException
     * @throws Coupons\NotStartedException
     * @throws Coupons\ExpiredException
     * @throws Coupons\InactiveException
     * @throws Coupons\MaxUsageException
     * @throws Coupons\OrderMinimumException
     * @throws Coupons\DeliveryFeesMinimumException
     */
    public function isValidToUse() : bool {
        if (!isset($this->coupon) || !$this->coupon) throw new Coupons\NotExistsException;

        if (!$this->coupon->is_started) throw new Coupons\NotStartedException($this->coupon->start_at);

        if ($this->coupon->is_expired) throw new Coupons\ExpiredException;

        if (!$this->coupon->is_active) throw new Coupons\InactiveException;

        if ($this->coupon->is_exceed_max_usage) throw new Coupons\MaxUsageException;

        if ($this->coupon->coupon_type == CouponType::GLOBAL && !$this->isMinimumAcceptable($this->totalPaidAmountInHalala))
            throw new Coupons\OrderMinimumException;

        if ($this->coupon->coupon_type == CouponType::FREE && !$this->isMinimumAcceptable($this->totalPaidAmountInHalala))
            throw new Coupons\DeliveryFeesMinimumException;

        return true;
    }

    private function isMinimumAcceptable($totalInHalala)
    {
        return ($this->coupon->minimum_order_amount == null) ||
            $this->coupon->minimum_order_amount_in_halala <= $totalInHalala;
    }

    private function isExceedCustomerMaxUsage(int $customerId)
    {
        return ($this->coupon->maximum_redemptions_per_user != null) &&
            $this->coupon->couponUser()->where('user_id', $customerId)->count() >= $this->coupon->maximum_redemptions_per_user;
    }
}
