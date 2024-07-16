<?php

namespace App\Enums;

enum CouponType {
    
    /**
     * The country is inactive state.
     */
    public const GLOBAL = 'global';

    /**
     * The coupon is percentage state.
     */
    public const VENDOR = 'vendor';

    /**
     * The country is active state.
     */
    public const PRODUCT = 'product';

    /**
     * The country is active state.
     */

    public const FREE = 'free_delivery';

    /**
     * Get country status list depending on app locale.
     *
     * @return array
     */
    public static function getCouponList(): array
    {
        return [
            self::GLOBAL => trans('admin.coupons.coupon_types.global'),
            self::PRODUCT => trans('admin.coupons.coupon_types.product'),
            self::FREE => trans('admin.coupons.coupon_types.free'),
            self::VENDOR => trans('admin.coupons.coupon_types.vendor')
        ]; 
    }

    public static function getCouponTypes(): array {
        return [
            self::GLOBAL,
            // self::PRODUCT,
            self::FREE,
            // self::VENDOR,
        ];
    }

    /**
     * Get country status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getCouponListWithClass(): array
    {
        return [
            self::GLOBAL => [
                "value" => self::GLOBAL, 
                "name" => trans('admin.coupons.coupon_types.global'),
                "class" => "badge text-bg-light"
            ],

            self::FREE => [
                "value" => self::FREE, 
                "name" => trans('admin.coupons.coupon_types.free'),
                "class" => "badge text-bg-light"
            ],

            // self::PRODUCT => [
            //     "value" => self::PRODUCT, 
            //     "name" => trans('admin.coupons.coupon_types.product'),
            //     "class" => "badge text-bg-light"
            // ],
            // self::VENDOR => [
            //     "value" => self::VENDOR,
            //     "name" => trans('admin.coupons.coupon_types.vendor'),
            //     "class" => "badge text-bg-light"
            // ]
        ]; 
    }

    /**
     * Get country status depending on app locale.
     *
     * @param bool $is_actistatusve
     * @return string
     */
    public static function getStatus(string $couponType): string
    {
        return self::getCouponList()[$couponType];
    }

    /**
     * Get country status with class color depending on app locale.
     *
     * @param int $is_active
     * @return array
     */
    public static function getCouponsWithClass(string $couponType): array
    {
    
        return self::getCouponListWithClass()[$couponType];
    }
}