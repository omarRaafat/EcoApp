<?php

namespace App\Enums;

enum VendorWarehouseRequestCreatedBy {
    /**
     * The Vendor Warehouse Request CreatedBy [ADMINI].
     */
    public const ADMINI = 1;

    /**
     * The Vendor Warehouse Request CreatedBy [VENDOR].
     */
    public const VENDOR = 2;

    /**
     * Get  The Vendor Warehouse Request CreatedBy list depending on app locale.
     *
     * @return array
     */
    public static function getCreatedByList(): array
    {
        return [
            self::INACTIVE => trans('admin.cities.inactive'),
            self::ACTIVE => trans('admin.cities.active')
        ]; 
    }

    /**
     * Get  The Vendor Warehouse Request CreatedBy list with class color depending on app locale.
     *
     * @return array
     */
    public static function getCreatedByListWithClass(): array
    {
        return [
            self::INACTIVE => [
                "value" => self::INACTIVE, 
                "name" => trans('admin.cities.inactive'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::ACTIVE => [
                "value" => self::ACTIVE,
                "name" => trans('admin.cities.active'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ]; 
    }

    /**
     * Get  The Vendor Warehouse Request CreatedBy depending on app locale.
     *
     * @param bool $created_by
     * @return string
     */
    public static function getCreatedBy(bool $created_by): string
    {
        return self::getCreatedByList()[$created_by];
    }

    /**
     * Get  The Vendor Warehouse Request CreatedBy with class color depending on app locale.
     *
     * @param int $created_by
     * @return array
     */
    public static function getCreatedByWithClass(int $created_by): array
    {
        return self::getCreatedByListWithClass()[$created_by];
    }
}