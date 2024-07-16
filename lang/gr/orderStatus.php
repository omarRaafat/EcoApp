<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::REGISTERD => 'Wird verarbeitet',
    OrderStatus::PAID => 'Wird verarbeitet',
    OrderStatus::SHIPPING_DONE => 'Geliefert',
    OrderStatus::IN_DELEVERY => 'raus zur Lieferung',
    OrderStatus::COMPLETED => 'Geliefert',
    OrderStatus::CANCELED => 'Stornieren',
    OrderStatus::REFUND => 'Abgelehnt',
    "website" => [
        OrderStatus::REGISTERD => 'Wird verarbeitet',
        OrderStatus::PAID => 'Wird verarbeitet',
        OrderStatus::IN_SHIPPING => 'Zur Auslieferung bereit',
        OrderStatus::SHIPPING_DONE => 'Geliefert',
        OrderStatus::IN_DELEVERY => 'Raus zur Lieferung',
        OrderStatus::COMPLETED => 'Geliefert',
        OrderStatus::CANCELED => 'Stornieren',
        OrderStatus::REFUND => 'Abgelehnt',
    ],
];
