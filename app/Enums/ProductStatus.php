<?php

namespace App\Enums;

enum ProductStatus {
    
    Const PENDING = 'pending';
    Const IN_REVIEW = 'in_review';
    Const HOLDED = 'holded';
    Const ACCEPTED = 'accepted';

    /**
     * Get wallet status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::PENDING=>trans('admin.product_statuses.'.self::PENDING),
            self::IN_REVIEW=>trans('admin.product_statuses.'.self::IN_REVIEW),
            self::HOLDED=>trans('admin.product_statuses.'.self::HOLDED),
            self::ACCEPTED=>trans('admin.product_statuses.'.self::ACCEPTED)
        ]; 
    }

    /**
     * Get wallet status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::PENDING => [
                "value" => self::PENDING, 
                "name" => trans('translation.product_statuses.'.self::PENDING),
                "class" => "badge badge-soft-secondary text-uppercase"
            ],
            self::IN_REVIEW => [
                "value" => self::IN_REVIEW,
                "name" => trans('translation.product_statuses.'.self::IN_REVIEW),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::HOLDED => [
                "value" => self::HOLDED,
                "name" => trans('translation.product_statuses.'.self::HOLDED),
                "class" => "badge badge-soft-primary text-uppercase"
            ],
            self::ACCEPTED => [
                "value" => self::ACCEPTED,
                "name" => trans('translation.product_statuses.'.self::ACCEPTED),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ]; 
    }

    /**
     * Get wallet status depending on app locale.
     *
     * @param bool $status
     * @return string
     */
    public static function getStatus(bool $status): string
    {
        return self::getStatusList()[$status];
    }

    /**
     * Get wallet status with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(string $status): array
    {
        return self::getStatusListWithClass()[$status];
    }
}