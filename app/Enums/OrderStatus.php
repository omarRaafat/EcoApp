<?php

namespace App\Enums;

enum OrderStatus {

    Const WAITINGPAY = 'waitingPay';// بانتظار الدفع
    Const REGISTERD = 'registered';// جاري التجهيز
    Const PAID = 'paid';
    Const IN_SHIPPING = 'in_shipping'; //جاري التوصيل
    Const PICKEDUP = 'PickedUp'; //التقطت من البائع
    Const SHIPPING_DONE = 'shipping_done';
    Const IN_DELEVERY = 'in_delivery';
    Const CONFIRMED = 'confirmed';
    Const PROCESSING = 'processing';
    Const COMPLETED = 'completed';
    Const CANCELED = 'canceled';
    Const REFUND = 'refund';

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
            self::REGISTERD => trans('orderStatus.'.self::REGISTERD),
            self::PROCESSING => trans('orderStatus.'.self::PROCESSING),
            self::PICKEDUP => trans('orderStatus.'.self::PICKEDUP),
            self::IN_DELEVERY => trans('orderStatus.'.self::IN_DELEVERY),
            self::IN_SHIPPING => trans('orderStatus.'.self::IN_SHIPPING),
            self::CONFIRMED => trans('orderStatus.'.self::CONFIRMED),

            self::COMPLETED => trans('orderStatus.'.self::COMPLETED),
            self::CANCELED => trans('orderStatus.'.self::CANCELED),
            self::REFUND => trans('orderStatus.'.self::REFUND),
            self::PAID => trans('orderStatus.'.self::PAID),
            self::WAITINGPAY => trans('orderstatus.'.self::WAITINGPAY),
//            self::SHIPPING_DONE => trans('orderStatus.'.self::SHIPPING_DONE),
//            self::IN_SHIPPING => trans('orderStatus.website.'.self::IN_SHIPPING),
//            self::IN_DELEVERY => trans('orderStatus.'.self::IN_DELEVERY),
            self::REFUND => trans('orderStatus.'.self::REFUND)
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
                "name" => trans('orderStatus.'.self::REGISTERD),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::PAID => [
                "value" => self::PAID,
                "name" => trans('orderStatus.'.self::PAID),
                "class" => "badge bg-success text-uppercase"
            ],
            self::CONFIRMED => [
                "value" => self::CONFIRMED,
                "name" => trans('orderStatus.'.self::CONFIRMED),
                "class" => "badge bg-secondary text-uppercase"
            ],
            self::PROCESSING => [
                "value" => self::PROCESSING,
                "name" => trans('orderStatus.'.self::PROCESSING),
                "class" => "badge bg-secondary text-uppercase"
            ],
            self::SHIPPING_DONE => [
                "value" => self::SHIPPING_DONE,
                "name" => trans('orderStatus.'.self::SHIPPING_DONE),
                "class" => "badge bg-success text-uppercase"
            ],
            self::IN_DELEVERY => [
                "value" => self::IN_DELEVERY,
                "name" => trans('orderStatus.'.self::IN_DELEVERY),
                "class" => "badge bg-primary text-uppercase"
            ],
            self::IN_SHIPPING => [
                "value" => self::IN_SHIPPING,
                "name" => trans('orderStatus.'.self::IN_SHIPPING),
                "class" => "badge bg-warning text-uppercase"
            ],
            self::COMPLETED => [
                "value" => self::COMPLETED,
                "name" => trans('orderStatus.'.self::COMPLETED),
                "class" => "badge bg-success text-uppercase"
            ],
            self::CANCELED => [
                "value" => self::CANCELED,
                "name" => trans('orderStatus.'.self::CANCELED),
                "class" => "badge bg-danger text-uppercase"
            ],
            self::REFUND => [
                "value" => self::REFUND,
                "name" => trans('orderStatus.'.self::REFUND),
                "class" => "badge bg-info text-uppercase"
            ],
            self::WAITINGPAY => [
                "value" => self::WAITINGPAY,
                "name" => trans('orderStatus.'.self::WAITINGPAY),
                "class" => "badge bg-primary text-uppercase"
            ],
            self::PICKEDUP => [
                "value" => self::PICKEDUP,
                "name" => trans('orderStatus.'.self::PICKEDUP),
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
            self::SHIPPING_DONE,
            self::IN_SHIPPING,
            self::PROCESSING,
            self::CONFIRMED,

            self::IN_DELEVERY,
            self::COMPLETED,
            self::CANCELED,
            self::REFUND,
        ];
    }

    public static function isStatusHasHigherOrder(string $oldStatus, string $newStatus) : bool {
        if ($oldStatus == $newStatus) true;
        switch($oldStatus) {
            case self::REGISTERD:
                return in_array($newStatus, [self::CANCELED, self::PAID, self::IN_DELEVERY, self::SHIPPING_DONE, self::COMPLETED]);
            case self::PAID:
                return in_array($newStatus, [self::CANCELED, self::IN_DELEVERY, self::SHIPPING_DONE, self::COMPLETED]);
            case self::IN_DELEVERY:
                return in_array($newStatus, [self::CANCELED, self::SHIPPING_DONE, self::COMPLETED]);
            case self::SHIPPING_DONE:
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
            self::REGISTERD => trans('orderStatus.website.'.self::REGISTERD),
            self::PAID => trans('orderStatus.website.'.self::PAID),
            self::PROCESSING => trans('orderStatus.website.'.self::PROCESSING),
            self::PICKEDUP => trans('orderStatus.website.'.self::PICKEDUP),
            self::CONFIRMED => trans('orderStatus.website.'.self::CONFIRMED),
            self::IN_SHIPPING => trans('orderStatus.website.'.self::IN_SHIPPING),
            self::SHIPPING_DONE => trans('orderStatus.website.'.self::SHIPPING_DONE),
            self::IN_DELEVERY => trans('orderStatus.website.'.self::IN_DELEVERY),
            self::COMPLETED => trans('orderStatus.website.'.self::COMPLETED),
            self::CANCELED => trans('orderStatus.website.'.self::CANCELED),
            self::REFUND => trans('orderStatus.website.'.self::REFUND),
            default => ""
        };
    }

    public static function getUnifiedStatusList(): array
    {
        return [
            self::REGISTERD => trans('orderStatus.'.self::REGISTERD),
            self::PROCESSING => trans('orderStatus.'.self::PROCESSING),
            self::PICKEDUP => trans('orderStatus.'.self::PICKEDUP),
            self::IN_SHIPPING => trans('orderStatus.'.self::IN_SHIPPING),
//            self::IN_DELEVERY => trans('orderStatus.'.self::IN_DELEVERY),
            self::COMPLETED => trans('orderStatus.'.self::COMPLETED),
            self::CANCELED => trans('orderStatus.'.self::CANCELED),
            self::REFUND => trans('orderStatus.'.self::REFUND),
        ];
    }

    public static function getUnifiedRefundStatusList(): array
    {
        return [
            self::NOFOUND => trans('orderStatus.'.self::NOFOUND),
            self::PENDING => trans('orderStatus.'.self::PENDING),
            self::REFUNDCOMPLETED => trans('orderStatus.'.self::REFUNDCOMPLETED),
        ];
    }
}
