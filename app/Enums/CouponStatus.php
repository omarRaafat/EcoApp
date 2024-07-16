<?php

namespace App\Enums;

enum CouponStatus {
    /**
     * The coupon is pending state.
     */
    public const PENDING = 'pending';
    /**
     * The coupon is approved state.
     */
    public const APPROVED = 'approved';
    /**
     * The coupon is rejected state.
     */
    public const REJECTED = 'rejected';

    /**
     * Get country status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::PENDING => trans('admin.coupons.pending'),
            self::APPROVED => trans('admin.coupons.approved'),
            self::REJECTED => trans('admin.coupons.rejected')
        ];
    }

    /**
     * Get country status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::PENDING => [
                "value" => self::PENDING,
                "name" => trans('admin.coupons.pending'),
                "class" => "badge badge-info text-uppercase"
            ],
            self::APPROVED => [
                "value" => self::APPROVED,
                "name" => trans('admin.coupons.approved'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::REJECTED => [
                "value" => self::REJECTED,
                "name" => trans('admin.coupons.rejected'),
                "class" => "badge badge-soft-danger text-uppercase"
            ]
        ];
    }

    /**
     * Get country status depending on app locale.
     *
     * @param bool $is_actistatusve
     * @return string
     */
    public static function getStatus(string $status): string
    {
        return self::getStatusList()[$status];
    }

    /**
     * Get country status with class color depending on app locale.
     *
     * @param int $is_active
     * @return array
     */
    public static function getStatusWithClass(string $status): array
    {

        return self::getStatusListWithClass()[$status];
    }
}
