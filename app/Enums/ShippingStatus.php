<?php

namespace App\Enums;

enum ShippingStatus
{
    const PENDING = "pending";
    const CONFIRMED = "confirmed";
    const DELIVERED = "delivered";
    const CANCELLED = "cancelled";

    /**
     * @return array
     */
    public static function shippingStatusList(): array
    {
        return [
            self::PENDING => trans('vendors.shipping_status.' . self::PENDING),
            self::CONFIRMED => trans('vendors.shipping_status.' . self::CONFIRMED),
            self::DELIVERED => trans('vendors.shipping_status.' . self::DELIVERED),
            self::CANCELLED => trans('vendors.shipping_status.' . self::CANCELLED),
        ];
    }

    public static function getShippingStatus($status): string
    {
        return self::shippingStatusList()[$status];
    }
}
