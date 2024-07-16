<?php
namespace App\Enums;

class VendorWallet {
    const IN = 'in';
    const OUT = 'out';

    public static function getTypes() {
        return [
            self::IN,
            self::OUT
        ];
    }

    public static function getTypesListWithClass(): array
    {
        return [
            self::IN => [
                "value" => self::IN,
                "name" => trans('admin.vendorWallets.in'),
                "class" => "badge badge-info text-uppercase"
            ],
            self::OUT => [
                "value" => self::OUT,
                "name" => trans('admin.vendorWallets.out'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ];
    }

    public static function getTypeWithClass($type): array
    {
        return self::getTypesListWithClass()[$type];
    }
}
