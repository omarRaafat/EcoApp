<?php
namespace App\Enums;

class CustomerWithdrawRequestEnum
{
    public const PENDING = "pending";
    public const APPROVED = "approved";
    public const NOT_APPROVED = "not_approved";

    public static function statuses() : array {
        return [
            self::PENDING,
            self::APPROVED,
            self::NOT_APPROVED,
        ];
    }
}