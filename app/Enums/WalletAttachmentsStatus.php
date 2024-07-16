<?php

namespace App\Enums;

enum WalletAttachmentsStatus {
    /**
     * The wallet has attachment state.
     */
    public const NO = 0;

    /**
     * The wallet has no attachment state.
     */
    public const YES = 1;

    /**
     * Get wallet attachments status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::NO => trans('admin.customer_finances.wallets.has_no_attachment'),
            self::YES => trans('admin.customer_finances.wallets.has_attachment')
        ]; 
    }

    /**
     * Get wallet attachments status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::NO => [
                "value" => self::NO, 
                "name" => trans('admin.customer_finances.wallets.has_no_attachment'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::YES => [
                "value" => self::YES,
                "name" => trans('admin.customer_finances.wallets.has_attachment'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ]; 
    }

    /**
     * Get wallet attachment status depending on app locale.
     *
     * @param bool $is_has_attachment
     * @return string
     */
    public static function getStatus(bool $is_has_attachment): string
    {
        return self::getStatusList()[$is_has_attachment];
    }

    /**
     * Get wallet attachment status with class color depending on app locale.
     *
     * @param int $is_has_attachment
     * @return array
     */
    public static function getStatusWithClass(int $is_has_attachment): array
    {
        return self::getStatusListWithClass()[$is_has_attachment];
    }
}