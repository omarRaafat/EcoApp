<?php

namespace App\Enums;

enum CertificateVendorApproval {
    
    Const PENDING = 'pending';
    Const REJECTED = 'rejected';
    Const APPROVED = 'approved';

    /**
     * Get wallet status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::PENDING=>trans('translation.certificate_approval.'.self::PENDING),
            self::REJECTED=>trans('translation.certificate_approval.'.self::REJECTED),
            self::APPROVED=>trans('translation.certificate_approval.'.self::APPROVED),
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
                "name" => trans('translation.certificate_approval.'.self::PENDING),
                "class" => "badge badge-soft-info text-uppercase"
            ],
            self::REJECTED => [
                "value" => self::REJECTED,
                "name" => trans('translation.certificate_approval.'.self::REJECTED),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::APPROVED => [
                "value" => self::APPROVED,
                "name" => trans('translation.certificate_approval.'.self::APPROVED),
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