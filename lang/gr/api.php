<?php

use App\Enums\OrderStatus;
use App\Enums\WalletTransactionTypes;

return [
    'categories-return-success'=> 'Kategorien wurden erfolgreich abgerufen',
    'category-return-success'=>'Kategorie wurde erfolgreich abgerufen',
    'products-return-success' => "Kategorien wurden erfolgreich abgerufen",
     'countries' =>[
         'retrived'=> 'Das Land wurde erfolgreich abgerufen',
     ],
     'settings'=>[
         'retrived'=> 'Die Daten wurden erfolgreich abgerufen',
     ],
     'shipping_methods'=>[
         'retrived'=> 'Lieferanten wurden erfolgreich abgerufen',
     ],
     'address-out-of-coverage' => "außer Deckung",
     'custom-transaction-status' => [
         OrderStatus::REGISTERD => 'In Bearbeitung',
         OrderStatus::PAID => 'In Bearbeitung',
         OrderStatus::IN_DELEVERY => 'In Bearbeitung',
         OrderStatus::SHIPPING_DONE => 'Abgeschlossen',
         OrderStatus::COMPLETED => 'Abgeschlossen',
         OrderStatus::CANCELED => 'Storniert',
     ],
     'wallet-transaction-types' => [
         WalletTransactionTypes::PURCHASE => "Produkte kaufen",
         WalletTransactionTypes::GIFT => "Geschenk",
         WalletTransactionTypes::BANK_TRANSFER => "Banküberweisung",
         WalletTransactionTypes::COMPENSATION => "Kompensation",
         WalletTransactionTypes::SALES_BALANCE => "Verkaufsbilanz",
     ],
    'country_products_delivery_to' =>  "Die Lieferung wurde erfolgreich in ein anderes Land umgestellt",
    'low-stock-label' => 'Die Menge ist begrenzt',
    'out-of-stock-label' => 'Ausverkauft',
];
