<?php

namespace App\Entities;

use Illuminate\Support\Arr;

abstract class ReferenceAbstract
{
    protected static $lists = [];

    protected static $colors = [];

    public static function get()
    {
        return collect(static::$lists);
    }

    public static function toArray()
    {
        return static::$lists;
    }

    public static function all()
    {
        return static::toArray();
    }

    public static function getById($singleId)
    {
        return static::$lists[$singleId];
    }

    public static function only(array $singleIds)
    {
        return Arr::only(static::$lists, $singleIds);
    }

    public static function except(array $singleIds)
    {
        return Arr::except(static::$lists, $singleIds);
    }

    public static function colors()
    {
        return static::$colors;
    }

    public static function getColorById($colorId)
    {
        return isset(static::$lists[$colorId]) ? static::$colors[$colorId] : null;
    }

    public static function colorsExcept(array $colorIds)
    {
        return Arr::except(static::$colors, $colorIds);
    }

    public static function colorsOnly(array $colorIds)
    {
        return Arr::only(static::$colors, $colorIds);
    }
}
