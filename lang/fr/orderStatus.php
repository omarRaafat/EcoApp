<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::REGISTERD => 'Être en cours de traitement',
    OrderStatus::PAID => 'Être en cours de traitement',
    OrderStatus::SHIPPING_DONE => 'Livré',
    OrderStatus::IN_DELEVERY => 'En cours de livraison',
    OrderStatus::COMPLETED => 'Complété',
    OrderStatus::CANCELED => 'Annulé',
    OrderStatus::REFUND => 'Rejeté',
    "website" => [
        OrderStatus::REGISTERD => 'Être en cours de traitement',
        OrderStatus::PAID => 'Être en cours de traitement',
        OrderStatus::IN_SHIPPING => 'Sorti pour l`expédition',
        OrderStatus::SHIPPING_DONE => 'Livré',
        OrderStatus::IN_DELEVERY => 'En cours de livraison',
        OrderStatus::COMPLETED => 'Livré',
        OrderStatus::CANCELED => 'Annuler',
        OrderStatus::REFUND => 'Rejeté',
    ],
];
