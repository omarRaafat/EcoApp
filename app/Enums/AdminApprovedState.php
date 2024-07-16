<?php

namespace App\Enums;

enum AdminApprovedState {

    /**
     * Admin approved status pending.
     */
    public const PENDING = 1;

    /**
     * Admin approved status approved.
     */
    public const APPROVED = 2;

    /**
     * Admin approved status rejected.
     */
    public const REJECTED = 3;

    /**
     * Admin approved status if null.
     */
    public const DEFAULT = null;

    /**
     * Get admin approved states list depending on app locale.
     *
     * @return array
     */
    public static function getLevelsList(): array
    {
        return [
            self::PENDING => trans('admin.admin_approved_state.pending'),
            self::APPROVED => trans('admin.admin_approved_state.approved'),
            self::REJECTED => trans('admin.admin_approved_state.rejected'),
            self::DEFAULT => trans('admin.admin_approved_state.pending'),
        ];
    }

    public static function getStateListOneLevel(): array
    {
        return [
            ["value" => self::PENDING, "name" => trans('admin.admin_approved_state.pending')],
            ["value" => self::APPROVED, "name" => trans('admin.admin_approved_state.approved')],
            ["value" => self::REJECTED, "name" => trans('admin.admin_approved_state.rejected')],
            ["value" => self::DEFAULT, "name" => trans('admin.admin_approved_state.pending')],
        ];
    }

    /**
     * Get admin approved states list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStateListWithClass(): array
    {
        return [
            self::PENDING => [
                "value" => self::PENDING,
                "name" => trans('admin.admin_approved_state.pending'),
                "class" => "badge badge-info text-uppercase"
            ],
            self::APPROVED => [
                "value" => self::APPROVED,
                "name" => trans('admin.admin_approved_state.approved'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::REJECTED => [
                "value" => self::REJECTED,
                "name" => trans('admin.admin_approved_state.rejected'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::DEFAULT => [
                "value" => self::DEFAULT,
                "name" => trans('admin.admin_approved_state.pending'),
                "class" => "badge badge-info text-uppercase"
            ],
        ];
    }

    /**
     * Get admin approved states depending on app locale.
     *
     * @param int|null $state
     * @return string
     */
    public static function getState(int|null $state): string
    {
        return self::getStateList()[$state];
    }

    /**
     * Get admin approved states with class color depending on app locale.
     *
     * @param int|null $state
     * @return array
     */
    public static function getStateWithClass(int|null $state): array
    {
        return self::getStateListWithClass()[$state];
    }
}
