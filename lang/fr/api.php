<?php

use App\Enums\OrderStatus;
use App\Enums\WalletTransactionTypes;

return [
	'categories-return-success'=> 'Les catégories ont été récupérées avec succès',
    'category-return-success'=>'la catégorie a été récupérée avec succès',
    'products-return-success' => "Les catégories ont été récupérées avec succès",
     'countries' =>[
         'retrived'=> 'Le pays a été récupéré avec succès',
     ],
     'settings'=>[
         'retrived'=> 'Les données ont été récupérées avec succès',
     ],
     'shipping_methods'=>[
         'retrived'=> 'Les expéditeurs ont été récupérés avec succès',
     ],
     'adresse-hors-couverture' => "hors couverture",
    'custom-transaction-status' => [
        OrderStatus::REGISTERD => 'En cours',
        OrderStatus::PAID => 'En cours',
        OrderStatus::IN_DELEVERY => 'En cours',
        OrderStatus::SHIPPING_DONE => 'Terminé',
        OrderStatus::COMPLETED => 'Terminé',
        OrderStatus::CANCELED => 'Annulé',
    ],
    'wallet-transaction-types' => [
        WalletTransactionTypes::PURCHASE => "Acheter des produits",
        WalletTransactionTypes::GIFT => "cadeau",
        WalletTransactionTypes::BANK_TRANSFER => "Virement bancaire",
        WalletTransactionTypes::COMPENSATION => "Rémunération",
        WalletTransactionTypes::SALES_BALANCE => "Solde des ventes",
    ],
    'country_products_delivery_to' =>  "La livraison a été modifiée avec succès vers un autre pays",
    'low-stock-label' => 'La quantité est limitée',
    'out-of-stock-label' => 'Rupture de stock',
];
