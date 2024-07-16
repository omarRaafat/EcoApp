<?php
namespace App\Enums;

enum ShippingMethodType {
    const NATIONAL = 'national';
    const INTERNATIONAL = 'international';

    public static function getTypes() : array {
        return [
            self::NATIONAL,
            self::INTERNATIONAL
        ];
    }

    public static function getTypesList() : array
    {
        return [
            self::NATIONAL=>__('admin.shippingMethods.'.self::NATIONAL),
            self::INTERNATIONAL=>__('admin.shippingMethods.'.self::INTERNATIONAL)
        ];
    }
}