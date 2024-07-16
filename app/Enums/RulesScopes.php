<?php

namespace App\Enums;

enum RulesScopes {
    /**
     * The rule scope = sub-admin.
     */
    public const SUBADMIN = "sub-admin";

    /**
     * The rule scope = vendor.
     */
    public const VENDOR = "vendor";

    /**
     * Get rule scopes list depending on app locale.
     *
     * @return array
     */
    public static function getScopesList(): array
    {
        return [
            self::SUBADMIN => trans('admin.rules.sub-admin'),
            self::VENDOR => trans('admin.rules.vendor')
        ]; 
    }

    /**
     * Get rules scopes list with class color depending on app locale.
     *
     * @return array
     */
    public static function getScopesListWithClass(): array
    {
        return [
            self::SUBADMIN => [
                "value" => self::SUBADMIN, 
                "name" => trans('admin.rules.sub-admin'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::VENDOR => [
                "value" => self::VENDOR,
                "name" => trans('admin.rules.vendor'),
                "class" => "badge badge-soft-warning text-uppercase"
            ]
        ]; 
    }

    /**
     * Get rules scope depending on app locale.
     *
     * @param string $scope
     * @return string
     */
    public static function getScope(string $scope): string
    {
        return self::getScopesList()[$scope];
    }

    /**
     * Get rules scope with class color depending on app locale.
     *
     * @param string $scope
     * @return array
     */
    public static function getScopeWithClass(string $scope): array
    {
        return self::getScopesListWithClass()[$scope];
    }
}