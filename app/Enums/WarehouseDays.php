<?php

namespace App\Enums;

class WarehouseDays
{
    const SAT = 'Sat';

    const SUN = 'Sun';

    const MON = 'Mon';
    const TUES = 'Tues';

    const WED = 'Wed';

    const THU = 'Thu';

    const FRI = 'Fri';
    public static function getDays(): array
    {
        return [
            self::SAT => trans('admin.warehouses.sat'),
            self::SUN => trans('admin.warehouses.sun'),
            self::MON => trans('admin.warehouses.mon'),
            self::TUES => trans('admin.warehouses.tues'),
            self::WED => trans('admin.warehouses.wed'),
            self::THU => trans('admin.warehouses.thu'),
            self::FRI => trans('admin.warehouses.fri'),
        ];
    }
    public static function getDay($status): string
    {
        return self::getDays()[$status] ?? "";
    }
}
