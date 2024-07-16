<?php

namespace App\Enums;

enum WalletHistoryTypeStatus {
    /**
     * The wallet transaction subtraction balance state.
     */
    public const SUB = 0;

    /**
     * The wallet transaction add balance state.
     */
    public const ADD = 1;

    /**
     * Get wallet transactions status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::SUB => trans('admin.customer_finances.wallets.transaction.sub'),
            self::ADD => trans('admin.customer_finances.wallets.transaction.add')
        ]; 
    }

    /**
     * Get wallet transactions status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::SUB => [
                "value" => self::SUB, 
                "name" => trans('admin.customer_finances.wallets.transaction.sub'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::ADD => [
                "value" => self::ADD,
                "name" => trans('admin.customer_finances.wallets.transaction.add'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ]; 
    }

    /**
     * Get wallet transaction status depending on app locale.
     *
     * @param bool $transaction_type
     * @return string
     */
    public static function getStatus(bool $transaction_type): string
    {
        return self::getStatusList()[$transaction_type];
    }

    /**
     * Get wallet transaction status with class color depending on app locale.
     *
     * @param int $transaction_type
     * @return array
     */
    public static function getStatusWithClass(int $transaction_type): array
    {
        return self::getStatusListWithClass()[$transaction_type];
    }
}