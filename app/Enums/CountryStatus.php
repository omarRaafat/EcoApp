<?php

namespace App\Enums;

enum CountryStatus {
    /**
     * The country is inactive state.
     */
    public const INACTIVE = 0;

    /**
     * The country is active state.
     */
    public const ACTIVE = 1;

    /**
     * Get country status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::INACTIVE => trans('admin.countries.inactive'),
            self::ACTIVE => trans('admin.countries.active')
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
            self::INACTIVE => [
                "value" => self::INACTIVE, 
                "name" => trans('admin.countries.inactive'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::ACTIVE => [
                "value" => self::ACTIVE,
                "name" => trans('admin.countries.active'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ]; 
    }

    /**
     * Get country status depending on app locale.
     *
     * @param bool $is_active
     * @return string
     */
    public static function getStatus(bool $is_active): string
    {
        return self::getStatusList()[$is_active];
    }

    /**
     * Get country status with class color depending on app locale.
     *
     * @param int $is_active
     * @return array
     */
    public static function getStatusWithClass(int $is_active): array
    {
        return self::getStatusListWithClass()[$is_active];
    }
}