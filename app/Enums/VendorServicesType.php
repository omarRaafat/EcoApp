<?php

namespace App\Enums;

enum VendorServicesType {

    public const SELLING_PRODUCTS = 'selling_products';
    public const AGRICULTURAL_SERVICES = 'agricultural_services';
    public const AGRICULTURAL_GUIDANCE = 'agricultural_guidance';


    /**
     * Get country status list depending on app locale.
     *
     * @return array
     */
    public static function getVendorServicesTypeList(): array
    {
        return [
            self::SELLING_PRODUCTS => trans('admin.vendor.service_types.selling_products'),
            self::AGRICULTURAL_SERVICES => trans('admin.vendor.service_types.agricultural_services'),
            self::AGRICULTURAL_GUIDANCE => trans('admin.vendor.service_types.agricultural_guidance'),
        ];
    }

    public static function getVendorServicesTypes(): array {
        return [
            self::SELLING_PRODUCTS,
            self::AGRICULTURAL_SERVICES,
            self::AGRICULTURAL_GUIDANCE,
        ];
    }

    /**
     * Get country status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getVendorServicesTypeListWithClass(): array
    {
        return [
            self::SELLING_PRODUCTS => [
                "value" => self::SELLING_PRODUCTS,
                "name" => trans('admin.vendor.service_types.selling_products'),
                "class" => "badge text-bg-light"
            ],
            self::AGRICULTURAL_SERVICES => [
                "value" => self::AGRICULTURAL_SERVICES,
                "name" => trans('admin.vendor.service_types.agricultural_services'),
                "class" => "badge text-bg-light"
            ],
            self::AGRICULTURAL_GUIDANCE => [
                "value" => self::AGRICULTURAL_GUIDANCE,
                "name" => trans('admin.vendor.service_types.agricultural_guidance'),
                "class" => "badge text-bg-light"
            ],
        ];
    }

    /**
     * Get country status depending on app locale.
     *
     * @param bool $is_activeStatus
     * @return string
     */
    public static function getStatus(string $vendorServicesType): string
    {
        return self::getVendorServicesTypeList()[$vendorServicesType];
    }

    /**
     * Get country status with class color depending on app locale.
     *
     * @param int $is_active
     * @return array
     */
    public static function getVendorServicesWithClass(string $vendorServicesType): array
    {

        return self::getVendorServicesTypeListWithClass()[$vendorServicesType];
    }
}
