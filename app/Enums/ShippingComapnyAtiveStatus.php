<?php

namespace App\Enums;

enum ShippingComapnyAtiveStatus {
    /**
     * The shipping company is inactive state.
     */
    public const INACTIVE = 0;

    /**
     * The shipping company is active state.
     */
    public const ACTIVE = 1;

    /**
     * Get shipping company status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::INACTIVE => trans('admin.torodCompanies.active'),
            self::ACTIVE => trans('admin.torodCompanies.inactive')
        ];
    }

    /**
     * Get shipping company status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::INACTIVE => [
                "value" => self::INACTIVE,
                "name" => trans('admin.torodCompanies.inactive'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::ACTIVE => [
                "value" => self::ACTIVE,
                "name" => trans('admin.torodCompanies.active'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ];
    }

    /**
     * Get torod company status depending on app locale.
     *
     * @param bool $is_active
     * @return string
     */
    public static function getStatus(bool $is_active): string
    {
        return self::getStatusList()[$is_active];
    }

    /**
     * Get torod company status with class color depending on app locale.
     *
     * @param int $is_active
     * @return array
     */
    public static function getStatusWithClass(int $is_active): array
    {
        return self::getStatusListWithClass()[$is_active];
    }
}
