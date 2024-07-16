<?php
namespace App\Enums;

enum DomesticZone {
    const NATIONAL_TYPE = "national";
    const INTERNATIONAL_TYPE = "international";

    public static function getTypes() : array {
        return [
            self::NATIONAL_TYPE => trans("admin.national"),
            // self::INTERNATIONAL_TYPE  => trans("admin.international"),
        ];
    }

    public static function getTypesArray() : array {
        return [
            self::NATIONAL_TYPE,
            self::INTERNATIONAL_TYPE,
        ];
    }
}