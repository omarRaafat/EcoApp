<?php

namespace App\Enums;

enum CategoryLevels {
    /**
     * Category Level One [The parent category].
     */
    public const PARENT = 1;

    /**
     * Category Level Two [The child category].
     */
    public const CHILD = 2;

    /**
     * Category Level Three - Last Level - [The sub-child category].
     */
    public const SUBCHILD = 3;

    /**
     * Get category levels list depending on app locale.
     *
     * @return array
     */
    public static function getLevelsList(): array
    {
        return [
            self::PARENT => trans('admin.categories.parent'),
            self::CHILD => trans('admin.categories.child'),
            self::SUBCHILD => trans('admin.categories.subchild'),
        ]; 
    }

    public static function getLevelsListOneLevel(): array
    {
        return [
            ["value" => self::PARENT, "name" => trans('admin.categories.parent')],
            ["value" => self::CHILD, "name" => trans('admin.categories.child')],
            ["value" => self::SUBCHILD, "name" => trans('admin.categories.subchild')],
        ]; 
    }

    /**
     * Get category levels list with class color depending on app locale.
     *
     * @return array
     */
    public static function getLevelsListWithClass(): array
    {
        return [
            self::PARENT => [
                "value" => self::PARENT, 
                "name" => trans('admin.categories.parent'),
                "class" => "badge badge-soft-danger text-uppercase"
            ],
            self::CHILD => [
                "value" => self::CHILD,
                "name" => trans('admin.categories.child'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
            self::SUBCHILD => [
                "value" => self::SUBCHILD,
                "name" => trans('admin.categories.subchild'),
                "class" => "badge badge-soft-success text-uppercase"
            ],
        ]; 
    }

    /**
     * Get category level depending on app locale.
     *
     * @param int $level
     * @return string
     */
    public static function getLevels(int $level): string
    {
        return self::getLevelsList()[$level];
    }

    /**
     * Get category level with class color depending on app locale.
     *
     * @param int $level
     * @return array
     */
    public static function getLevelsWithClass(int $level): array
    {
        return self::getLevelsListWithClass()[$level];
    }
}