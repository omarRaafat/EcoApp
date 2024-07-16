<?php

use App\Enums\OrderStatus;
use App\Enums\WalletTransactionTypes;

return [
    'Unauthorized' => 'من فضلك قم بتسجيل الدخول اولا' ,
	'categories-return-success'=> "تم إسترجاع التصنيفات بنجاح",
	'category-return-success'=>"تم إسترجاع التصنيف بنجاح",
	'products-return-success' =>  "تم إسترجاع التصنيفات بنجاح",

    'countries'=>[
        'retrived'=> 'تم استرجاع البلاد بنجاح',
    ],
    'settings'=>[
        'retrived'=> 'تم استرجاع البيانات بنجاح',
    ],
    'shipping_methods'=>[
        'retrived'=> 'تم استرجاع شركات الشحن بنجاح',
    ],
    'address-out-of-coverage' => "خارج نطاق التوصيل",
    'custom-transaction-status' => [
        OrderStatus::REGISTERD => 'قيد العمل',
        OrderStatus::PAID => 'قيد العمل',
        OrderStatus::PICKEDUP => 'تم الإلتقاط',
        OrderStatus::IN_DELEVERY => 'قيد العمل',
        OrderStatus::SHIPPING_DONE => 'مكتمل',
        OrderStatus::COMPLETED => 'مكتمل',
        OrderStatus::CANCELED => 'ملغي',
        OrderStatus::REFUND => 'مرتجع',
    ],
    'wallet-transaction-types' => [
        WalletTransactionTypes::PURCHASE => "شراء منتجات",
        WalletTransactionTypes::GIFT => "هدية",
        WalletTransactionTypes::BANK_TRANSFER => "حوالة بنكية",
        WalletTransactionTypes::COMPENSATION => "تعويض",
        WalletTransactionTypes::SALES_BALANCE => "رصيد مبيعات",
    ],
    'country_products_delivery_to' =>  "تم تغير التوصيل الى دولة اخرى بنجاح",
    'low-stock-label' => 'الكمية محدودة',
    'out-of-stock-label' => 'نفذ من المخزون',
];
