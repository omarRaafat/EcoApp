<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::REGISTERD => 'Sedang dalam proses',
    OrderStatus::PAID => 'Sedang dalam proses',
    OrderStatus::SHIPPING_DONE => 'Terkirim',
    OrderStatus::IN_DELEVERY => 'Keluar untuk pengiriman',
    OrderStatus::COMPLETED => 'terkirim',
    OrderStatus::CANCELED => 'Membatalkan',
    OrderStatus::REFUND => 'Ditolak',
    "website" => [
        OrderStatus::REGISTERD => 'Sedang dalam proses',
        OrderStatus::PAID => 'Sedang dalam proses',
        OrderStatus::IN_SHIPPING => 'Siap untuk diantar',
        OrderStatus::SHIPPING_DONE => 'terkirim',
        OrderStatus::IN_DELEVERY => 'Keluar untuk pengiriman',
        OrderStatus::COMPLETED => 'terkirim',
        OrderStatus::CANCELED => 'Membatalkan',
        OrderStatus::REFUND => 'Ditolak',
    ],
];
