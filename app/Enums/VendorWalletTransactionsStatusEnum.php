<?php

namespace App\Enums;

enum VendorWalletTransactionsStatusEnum {

    Const PENDING = 'pending';
    Const COMPLETED = 'completed';

    public static function getStatusList(): array
    {
        return [
            self::PENDING => trans('admin.vendorWallets.wallets_transactions.'.self::PENDING),
            self::COMPLETED => trans('admin.vendorWallets.wallets_transactions.'.self::COMPLETED),
        ];
    }

    public static function getStatus(string $status): string
    {
        return self::getStatusList()[$status];
    }
}
