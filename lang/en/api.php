<?php

use App\Enums\OrderStatus;
use App\Enums\WalletTransactionTypes;

return [
    'Unauthorized' => 'Unauthorized' ,
    'categories-return-success'=> "Categories have been successfully retrieved",
	'category-return-success'=>"The category has been successfully retrieved",
	'products-return-success' =>  "Products have been successfully retrieved",

    'countries'=>[
        'retrived'=> 'The country has been successfully recovered',
    ],
    'settings'=>[
        'retrived'=> 'The data has been successfully retrieved',
    ],
    'shipping_methods'=>[
        'retrived'=> 'Shipping methods has been successfully retrieved',
    ],
    'address-out-of-coverage' => "Address out of coverage",
    'custom-transaction-status' => [
        OrderStatus::REGISTERD => 'In Progress',
        OrderStatus::PAID => 'In Progress',
        OrderStatus::IN_DELEVERY => 'In Progress',
        OrderStatus::SHIPPING_DONE => 'Completed',
        OrderStatus::COMPLETED => 'Completed',
        OrderStatus::CANCELED => 'Cancelled',
    ],
    'wallet-transaction-types' => [
        WalletTransactionTypes::PURCHASE => "Purchase",
        WalletTransactionTypes::GIFT => "Gift",
        WalletTransactionTypes::BANK_TRANSFER => "Bank Transfer",
        WalletTransactionTypes::COMPENSATION => "Compensation",
        WalletTransactionTypes::SALES_BALANCE => "Sales Balance",
    ],
    'country_products_delivery_to' =>  "The delivery has been changed to another country successfully",
    'low-stock-label' => 'The quantity is limited',
    'out-of-stock-label' => 'Out of stock',
];
