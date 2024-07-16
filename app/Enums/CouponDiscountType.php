<?php

namespace App\Enums;

enum CouponDiscountType {
    /**
     * The country is inactive state.
     */
    public const FIXED = 'fixed';

    /**
     * The country is active state.
     */
    public const PERCENTAGE = 'percentage';

    /**
     * Get country status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::FIXED => trans('admin.coupons.fixed'),
            self::PERCENTAGE => trans('admin.coupons.percentage')
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
            self::FIXED => [
                "value" => self::FIXED, 
                "name" => trans('admin.coupons.fixed'),
                "class" => "badge text-bg-light"
            ],
            self::PERCENTAGE => [
                "value" => self::PERCENTAGE,
                "name" => trans('admin.coupons.percentage'),
                "class" => "badge text-bg-light"
            ]
        ]; 
    }

    /**
     * Get country status depending on app locale.
     *
     * @param bool $is_actistatusve
     * @return string
     */
    public static function getStatus(string $discountType): string
    {
        return self::getStatusList()[$discountType];
    }

    /**
     * Get country status with class color depending on app locale.
     *
     * @param int $is_active
     * @return array
     */
    public static function getStatusWithClass(string $discountType): array
    {
    
        return self::getStatusListWithClass()[$discountType];
    }
}