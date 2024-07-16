<?php
use App\Enums\OrderStatus;
use App\Enums\WalletTransactionTypes;

return [
	'categories-return-success'=> "Kategori telah berhasil diambil",
	'category-return-success'=>"Kategori telah berhasil diambil",
	'products-return-success' =>  "Kategori telah berhasil diambil",
    'countries'=>[
        'retrived'=>"Negara telah berhasil dipulihkan",
    ],
    'settings'=>[
        "Data berhasil diambil",
    ],
    'shipping_methods'=>[
        "Pengirim telah berhasil diambil",
    ],
    'address-out-of-coverage' => "di luar jangkauan pengiriman",
    'custom-transaction-status' => [
        OrderStatus::REGISTERD => "sedang berlangsung",
        OrderStatus::PAID => "sedang berlangsung",
        OrderStatus::IN_DELEVERY => "sedang berlangsung",
        OrderStatus::SHIPPING_DONE => "menyelesaikan",
        OrderStatus::COMPLETED => "menyelesaikan",
        OrderStatus::CANCELED => "dibatalkan",
    ],
    'wallet-transaction-types' => [
        WalletTransactionTypes::PURCHASE =>  "membeli produk",
        WalletTransactionTypes::GIFT =>  "hadiah",
        WalletTransactionTypes::BANK_TRANSFER => "transfer Bank",
        WalletTransactionTypes::COMPENSATION => "kompensasi",
        WalletTransactionTypes::SALES_BALANCE => "Saldo penjualan"
    ],
    'country_products_delivery_to' =>  "Pengiriman telah berhasil diubah ke negara lain",
    'low-stock-label' => 'Jumlahnya terbatas',
    'out-of-stock-label' => 'Stok Habis',
];
