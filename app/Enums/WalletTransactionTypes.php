<?php

namespace App\Enums;

enum WalletTransactionTypes {

    /**
     * withdraw from  Wallet when PURCHASE product.
     */
    public const PURCHASE = 1;


    /**
     * Charging Wallet as a compensation
     */
    public const COMPENSATION = 2;

    /**
     * Charging Wallet By bank transfer.
     */
    public const BANK_TRANSFER = 3;

    /**
     * Charging Wallet as a gift.
     */
    public const GIFT = 4;

    /**\
     * Change Wallet as Sales balance.
     */
    public const SALES_BALANCE = 5;

    /**
     * Get transactions types list depending on app locale.
     *
     * @return array
     */
    public static function getTypesList(): array
    {
        return [
            self::PURCHASE => trans('admin.customer_finances.wallets.transaction.transaction_type.purchase'),
            self::COMPENSATION => trans('admin.customer_finances.wallets.transaction.transaction_type.compensation'),
            self::BANK_TRANSFER => trans('admin.customer_finances.wallets.transaction.transaction_type.bank_transfer'),
            self::GIFT => trans('admin.customer_finances.wallets.transaction.transaction_type.gift'),
            self::SALES_BALANCE => trans('admin.customer_finances.wallets.transaction.transaction_type.sales_balance'),
        ];
    }

    /**
     * Get transactions types list with class color depending on app locale.
     *
     * @return array
     */
    public static function getTypesListWithClass(): array
    {
        return [
            self::BANK_TRANSFER => [
                "value" => self::BANK_TRANSFER,
                "name" => trans('admin.customer_finances.wallets.transaction.transaction_type.bank_transfer')
            ],
            self::COMPENSATION => [
                "value" => self::COMPENSATION,
                "name" => trans('admin.customer_finances.wallets.transaction.transaction_type.compensation')
            ],
            self::GIFT => [
                "value" => self::GIFT,
                "name" => trans('admin.customer_finances.wallets.transaction.transaction_type.gift')
            ],
            self::PURCHASE => [
                "value" => self::PURCHASE,
                "name" => trans('admin.customer_finances.wallets.transaction.transaction_type.purchase')
            ],
            self::SALES_BALANCE => [
                "value" => self::SALES_BALANCE,
                "name" => trans('admin.customer_finances.wallets.transaction.transaction_type.sales_balance')
            ],
        ];
    }

    /**
     * Get transactions types depending on app locale.
     *
     * @param int $type
     * @return string
     */
    public static function getTypes(int $type): string
    {
        return self::getTypesList()[$type];
    }

    /**
     * Get wallet Types with class color depending on app locale.
     *
     * @param int $type
     * @return array
     */
    public static function getTypesWithClass(int $type): array
    {
        return self::getTypesListWithClass()[$type];
    }

    public static function getTypesArray(): array
    {
        return [
            self::PURCHASE,
            self::COMPENSATION,
            self::BANK_TRANSFER,
            self::GIFT,
            self::SALES_BALANCE
        ];
    }
}
