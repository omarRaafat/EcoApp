<?php
namespace App\Enums;

class WarehouseIntegrationKeys {
    const NATIONAL_WAREHOUSE = 'SAUDI_NATIONAL_WAREHOUSE';

    public static function getKeys() : array {
        return [
            self::NATIONAL_WAREHOUSE => __('admin.integrations.national-warehouse'),
        ];
    }
}
