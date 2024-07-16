<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::REGISTERD => 'Being processed',
    OrderStatus::PAID => 'Being processed',
    OrderStatus::SHIPPING_DONE => 'Delivered',
    OrderStatus::IN_DELEVERY => 'Out For Delivery',
    OrderStatus::COMPLETED => 'Completed',
    OrderStatus::PROCESSING => 'Processing',
    OrderStatus::CANCELED => 'Canceled',
    OrderStatus::REFUND => 'Rejected',
    "website" => [
        OrderStatus::REGISTERD => 'Being processed',
        OrderStatus::PAID => 'Being processed',
        OrderStatus::IN_SHIPPING => 'Out For Shipping',
        OrderStatus::SHIPPING_DONE => 'Delivered',
        OrderStatus::IN_DELEVERY => 'Out For Delivery',
        OrderStatus::COMPLETED => 'Delivered',
        OrderStatus::CANCELED => 'Canceled',
        OrderStatus::REFUND => 'Rejected',
    ],
];
