<?php

use App\Enums\OrderShipStatus;
use App\Enums\OrderStatus;

return [
    OrderStatus::REGISTERD => 'جارى التجهيز',
    OrderStatus::PAID => 'تم الدفع',
    OrderStatus::PROCESSING => 'تم التجهيز',
    OrderStatus::PICKEDUP => 'تم الإلتقاط',
    OrderStatus::IN_SHIPPING => 'جاري التوصيل',
    OrderStatus::SHIPPING_DONE => 'تم التوصيل',
    OrderStatus::IN_DELEVERY => 'جاري التوصيل',
    OrderStatus::COMPLETED => 'تم التوصيل',
    OrderStatus::CANCELED => 'ملغي',
    OrderStatus::REFUND => 'مرتجع',
    OrderStatus::WAITINGPAY => 'انتظار الدفع',

    OrderStatus::CONFIRMED => 'تم التجيهز',

    "website" => [
        OrderStatus::REGISTERD => 'جارى التجهيز',
        OrderStatus::PAID => 'تم الدفع',
        OrderStatus::PROCESSING => 'تم التجهيز',
        OrderStatus::PICKEDUP => 'تم الإلتقاط',
        OrderStatus::IN_SHIPPING => 'جاري التوصيل ',
        OrderStatus::SHIPPING_DONE => 'تم التوصيل',
        OrderStatus::IN_DELEVERY => 'جاري التوصيل',
        OrderStatus::COMPLETED => 'تم التوصيل',
        OrderStatus::CANCELED => 'ملغي',
        OrderStatus::REFUND => 'مرتجع',
        OrderStatus::CONFIRMED => 'تم التجيهز',

    ],

    "orderStatusShip" => [
        OrderShipStatus::PENDING => 'جارى التجهيز',
        OrderShipStatus::PICKEDUP => 'تم الإلتقاط',
        OrderShipStatus::CONFIRMED => 'تم التأكيد',
        OrderShipStatus::DELIVERED => 'جاري التوصيل',
        OrderShipStatus::CANCELED => 'تم الإلغاء',

    ],
];
