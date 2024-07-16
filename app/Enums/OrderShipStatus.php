<?php

namespace App\Enums;

enum OrderShipStatus
{

    const PENDING = 'pending';
    Const PICKEDUP = 'PickedUp'; //التقطت من البائع
    const CONFIRMED = 'confirmed';
    const DELIVERED = 'delivered';

    const CANCELED = 'canceled';

    /**
     * Get wallet status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::PENDING => trans('orderStatus.orderStatusShip.' . self::PENDING),
            self::PENDING => trans('orderStatus.orderStatusShip.' . self::PICKEDUP),
            self::CONFIRMED => trans('orderStatus.orderStatusShip.' . self::CONFIRMED),
            self::DELIVERED => trans('orderStatus.orderStatusShip.' . self::DELIVERED),
            self::CANCELED => trans('orderStatus.orderStatusShip.' . self::CANCELED),
        ];
    }

    /**
     * Get wallet status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::PENDING => [
                "value" => self::PENDING,
                "name" => trans('orderStatus.' . self::PENDING),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::PICKEDUP => [
                "value" => self::PICKEDUP,
                "name" => trans('orderStatus.' . self::PICKEDUP),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::CONFIRMED => [
                "value" => self::CONFIRMED,
                "name" => trans('orderStatus.' . self::CONFIRMED),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::DELIVERED => [
                "value" => self::DELIVERED,
                "name" => trans('orderStatus.' . self::DELIVERED),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::CANCELED => [
                "value" => self::CANCELED,
                "name" => trans('orderStatus.' . self::CANCELED),
                "class" => "badge badge-soft-success text-uppercase"
            ],
        ];
    }

    /**
     * Get wallet status depending on app locale.
     *
     * @param  $status
     * @return string
     */
    public static function getStatus($status): string
    {
        return self::getStatusList()[$status] ?? "";
    }

    /**
     * Get wallet status with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(string $status): array
    {
        return self::getStatusListWithClass()[$status] ?? ['class' => '', 'name' => ''];
    }

    public static function getStatuses(): array
    {
        return [
            self::PENDING,
            self::CONFIRMED,
            self::DELIVERED,
            self::CANCELED,
        ];
    }
}
