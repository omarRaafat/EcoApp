<?php
namespace App\Enums;

enum VendorAgreementEnum
{
    const PENDING = "pending";
    const APPROVED = "approved";
    const CANCELED = "canceled";

    public static function getStatuses() : array {
        return [
            self::PENDING,
            self::APPROVED,
            self::CANCELED,
        ];
    }

    public static function getStatusesTranslated() : array {
        return [
            self::PENDING => __("admin.vendors-agreements-keys.". self::PENDING),
            self::APPROVED => __("admin.vendors-agreements-keys.". self::APPROVED),
            self::CANCELED => __("admin.vendors-agreements-keys.". self::CANCELED),
        ];
    }
}
