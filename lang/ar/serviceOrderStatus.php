<?php

use App\Enums\OrderShipStatus;
use App\Enums\ServiceOrderStatus;

return [
    ServiceOrderStatus::REGISTERD => 'طلب جديد',
    ServiceOrderStatus::PAID => 'تم الدفع',
    ServiceOrderStatus::PROCESSING => 'جاري تقديم الخدمة',
    ServiceOrderStatus::COMPLETED => 'تمت الخدمة',
    ServiceOrderStatus::CANCELED => 'ملغي',
    ServiceOrderStatus::WAITINGPAY => 'انتظار الدفع',
    ServiceOrderStatus::CONFIRMED => 'تم التجيهز',
    "website" => [
        ServiceOrderStatus::REGISTERD => 'طلب جديد',
        ServiceOrderStatus::PAID => 'تم الدفع',
        ServiceOrderStatus::PROCESSING => 'جاري تقديم الخدمة',
        ServiceOrderStatus::COMPLETED => 'تمت الخدمة',
        ServiceOrderStatus::CANCELED => 'ملغي',
        ServiceOrderStatus::CONFIRMED => 'تم التجيهز',
    ],
    "orderStatusShip" => [
        OrderShipStatus::PENDING => 'طلب جديد',
        OrderShipStatus::CONFIRMED => 'تم التأكيد',
        OrderShipStatus::CANCELED => 'تم الإلغاء',
    ],
];
