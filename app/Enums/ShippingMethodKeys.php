<?php
namespace App\Enums;

use Exception;

enum ShippingMethodKeys {
    const BEZZ_KEY = "national-shipping-method-BEZZ";

    const SPL_KEY = "international-shipping-method-SPL";

    const ARAMEX_KEY = "international-shipping-method-ARAMEX";

    public static function getKeys() : array {
        return [
            self::BEZZ_KEY => __('admin.shippingMethods.bezz'),
            self::SPL_KEY => __('admin.shippingMethods.spl'),
            self::ARAMEX_KEY => __('admin.shippingMethods.aramex'),
        ];
    }

    public static function getKeysArray()
    {
        return [
            self::BEZZ_KEY,
            self::SPL_KEY,
            self::ARAMEX_KEY,
        ];
    }

    public static function convertKeyToId(string $key) {
        switch($key) {
            case self::BEZZ_KEY:
                return ShippingMethods::BEZZ;
            case self::SPL_KEY:
                return ShippingMethods::SPL;
            case self::ARAMEX_KEY:
                return ShippingMethods::ARAMEX;
        }
        throw new Exception("Unknown shipping method");
    }
}
