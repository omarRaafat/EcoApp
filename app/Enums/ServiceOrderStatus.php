<?php

namespace App\Enums;

enum ServiceOrderStatus {

    Const WAITINGPAY = 'waitingPay';// بانتظار الدفع
    Const REGISTERD = 'registered'; //طلب جديد
    Const PAID = 'paid';
    Const CONFIRMED = 'confirmed';
    Const PROCESSING = 'processing'; // جاري تقديم الخدمة
    Const COMPLETED = 'completed'; // تمت الخدمة
    Const CANCELED = 'canceled';

    Const NOFOUND = 'no_found';
    Const PENDING = 'pending';
    Const REFUNDCOMPLETED = 'completed';


    /**
     * Get wallet status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::REGISTERD => trans('serviceOrderStatus.'.self::REGISTERD),
            self::PROCESSING => trans('serviceOrderStatus.'.self::PROCESSING),
            self::CONFIRMED => trans('serviceOrderStatus.'.self::CONFIRMED),

            self::COMPLETED => trans('serviceOrderStatus.'.self::COMPLETED),
            self::CANCELED => trans('serviceOrderStatus.'.self::CANCELED),
            self::PAID => trans('serviceOrderStatus.'.self::PAID),
            self::WAITINGPAY => trans('orderstatus.'.self::WAITINGPAY),
//            self::SHIPPING_DONE => trans('serviceOrderStatus.'.self::SHIPPING_DONE),
//            self::IN_SHIPPING => trans('serviceOrderStatus.website.'.self::IN_SHIPPING),
//            self::IN_DELEVERY => trans('serviceOrderStatus.'.self::IN_DELEVERY),
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
            self::REGISTERD => [
                "value" => self::REGISTERD,
                "name" => trans('serviceOrderStatus.'.self::REGISTERD),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::PAID => [
                "value" => self::PAID,
                "name" => trans('serviceOrderStatus.'.self::PAID),
                "class" => "badge bg-success text-uppercase"
            ],
            self::CONFIRMED => [
                "value" => self::CONFIRMED,
                "name" => trans('serviceOrderStatus.'.self::CONFIRMED),
                "class" => "badge bg-secondary text-uppercase"
            ],
            self::PROCESSING => [
                "value" => self::PROCESSING,
                "name" => trans('serviceOrderStatus.'.self::PROCESSING),
                "class" => "badge bg-secondary text-uppercase"
            ],
            self::COMPLETED => [
                "value" => self::COMPLETED,
                "name" => trans('serviceOrderStatus.'.self::COMPLETED),
                "class" => "badge bg-success text-uppercase"
            ],
            self::CANCELED => [
                "value" => self::CANCELED,
                "name" => trans('serviceOrderStatus.'.self::CANCELED),
                "class" => "badge bg-danger text-uppercase"
            ],
            self::WAITINGPAY => [
                "value" => self::WAITINGPAY,
                "name" => trans('serviceOrderStatus.'.self::WAITINGPAY),
                "class" => "badge bg-primary text-uppercase"
            ],
        ];
    }

    /**
     * Get wallet status depending on app locale.
     *
     * @param $status
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
            self::REGISTERD,
            self::PAID,
            self::PROCESSING,
            self::CONFIRMED,
            self::COMPLETED,
            self::CANCELED,
        ];
    }

    public static function isStatusHasHigherOrder(string $oldStatus, string $newStatus) : bool {
        if ($oldStatus == $newStatus) true;
        switch($oldStatus) {
            case self::REGISTERD:
                return in_array($newStatus, [self::CANCELED, self::PAID, self::COMPLETED]);
            case self::PAID:
                return in_array($newStatus, [self::CANCELED, self::COMPLETED]);
            case self::COMPLETED:
                return in_array($newStatus, [self::CANCELED]);
        }
        return false;
    }

    /**
     * @param string $status
     * @return string
     */
    public static function getWebsiteStatusTranslated(string $status): string
    {
        return match ($status) {
            self::REGISTERD => trans('serviceOrderStatus.website.'.self::REGISTERD),
            self::PAID => trans('serviceOrderStatus.website.'.self::PAID),
            self::PROCESSING => trans('serviceOrderStatus.website.'.self::PROCESSING),
            self::CONFIRMED => trans('serviceOrderStatus.website.'.self::CONFIRMED),
            self::COMPLETED => trans('serviceOrderStatus.website.'.self::COMPLETED),
            self::CANCELED => trans('serviceOrderStatus.website.'.self::CANCELED),
            default => ""
        };
    }

    public static function getUnifiedStatusList(): array
    {
        return [
            self::REGISTERD => trans('serviceOrderStatus.'.self::REGISTERD),
            self::PROCESSING => trans('serviceOrderStatus.'.self::PROCESSING),
//            self::IN_DELEVERY => trans('serviceOrderStatus.'.self::IN_DELEVERY),
            self::COMPLETED => trans('serviceOrderStatus.'.self::COMPLETED),
            self::CANCELED => trans('serviceOrderStatus.'.self::CANCELED),
        ];
    }

    public static function getUnifiedRefundStatusList(): array
    {
        return [
            self::NOFOUND => trans('serviceOrderStatus.'.self::NOFOUND),
            self::PENDING => trans('serviceOrderStatus.'.self::PENDING),
            self::REFUNDCOMPLETED => trans('serviceOrderStatus.'.self::REFUNDCOMPLETED),
        ];
    }
}
