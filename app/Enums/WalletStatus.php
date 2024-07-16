<?php

namespace App\Enums;

enum WalletStatus {
    /**
     * The wallet is inactive state.
     */
    public const INACTIVE = 0;

    /**
     * The wallet is active state.
     */
    public const ACTIVE = 1;

    /**
     * Get wallet status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::INACTIVE => trans('admin.customer_finances.wallets.inactive'),
            self::ACTIVE => trans('admin.customer_finances.wallets.active')
        ]; 
    }

    /**
     * Get wallet status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::INACTIVE => [
                "value" => self::INACTIVE, 
                "name" => trans('admin.customer_finances.wallets.inactive'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::ACTIVE => [
                "value" => self::ACTIVE,
                "name" => trans('admin.customer_finances.wallets.active'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ]; 
    }

    /**
     * Get wallet status depending on app locale.
     *
     * @param bool $is_active
     * @return string
     */
    public static function getStatus(bool $is_active): string
    {
        return self::getStatusList()[$is_active];
    }

    /**
     * Get wallet status with class color depending on app locale.
     *
     * @param int $is_active
     * @return array
     */
    public static function getStatusWithClass(int $is_active): array
    {
        return self::getStatusListWithClass()[$is_active];
    }
}