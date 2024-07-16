<?php

namespace App\Enums;

enum NationalCountry {
    /**
     * The country is national .
     */
    public const NATIONAL = 1;

    /**
     * The country is not national .
     */
    public const NOTNATIONAL = 0;

    /**
     * Get country status list depending on app locale.
     *
     * @return array
     */
    public static function getCountryTypeList(): array
    {
        return [
            self::NATIONAL => trans('admin.countries.national'),
            self::NOTNATIONAL => trans('admin.countries.not_national')
        ]; 
    }

    /**
     * Get country national badge
     *
     * @return array
     */
    public static function getCountryTypeListWithClass(): array
    {
        return [
            self::NOTNATIONAL => [
                "value" => self::NOTNATIONAL, 
                "name" => trans('admin.countries.not_national'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::NATIONAL => [
                "value" => self::NATIONAL,
                "name" => trans('admin.countries.national'),
                "class" => "badge badge-soft-success text-uppercase"
            ]
        ]; 
    }

    /**
     * Get country status depending on app locale.
     *
     * @param bool $is_active
     * @return string
     */
    public static function getType(bool $is_national): string
    {
        return self::getCountryTypeList()[$is_national];
    }

    /**
     * Get country status with class color depending on app locale.
     *
     * @param int $is_national
     * @return array
     */
    public static function getTypeWithClass(int $is_national): array
    {
        return self::getCountryTypeListWithClass()[$is_national];
    }
}