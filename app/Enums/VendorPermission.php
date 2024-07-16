<?php

namespace App\Enums;

enum VendorPermission {

    Const ORDERS = 'order';
    Const PRODUCT = 'product';
    Const USER = 'user';
    Const REVIEW = 'review';
    Const ROLE = 'role';
    Const CERTIFICATE = 'certificate';
    Const WAREHOUSE = 'warehouse';
    Const REPORTS = 'reports';
    Const STATISTICS = 'statistics';
    Const SERVICES = 'services';
    Const ORDER_SERVICES = 'order_services';
    Const TYPE_OF_EMPLOYEES = 'type_of_employees';


    /**
     * Get wallet permission list depending on app locale.
     *
     * @return array
     */
    public static function getPermissionList(): array
    {
        return [
            self::ORDERS => trans('vendors.permissions_keys.'.self::ORDERS),
            self::PRODUCT => trans('vendors.permissions_keys.'.self::PRODUCT),
            self::USER => trans('vendors.permissions_keys.'.self::USER),
            self::REVIEW => trans('vendors.permissions_keys.'.self::REVIEW),
            self::ROLE => trans('vendors.permissions_keys.'.self::ROLE),
            self::CERTIFICATE => trans('vendors.permissions_keys.'.self::CERTIFICATE),
            self::WAREHOUSE => trans('vendors.permissions_keys.'.self::WAREHOUSE),
            self::REPORTS => trans('vendors.permissions_keys.'.self::REPORTS),
            self::STATISTICS => trans('vendors.permissions_keys.'.self::STATISTICS),
            self::SERVICES => trans('vendors.permissions_keys.'.self::SERVICES),
            self::ORDER_SERVICES => trans('vendors.permissions_keys.'.self::ORDER_SERVICES),
            self::TYPE_OF_EMPLOYEES => trans('vendors.permissions_keys.'.self::TYPE_OF_EMPLOYEES),


        ];
    }

    /**
     * Get wallet permission depending on app locale.
     *
     * @param bool $permission
     * @return string
     */
    public static function getPermission($permission): string
    {
        return self::getPermissionList()[$permission];
    }
}
