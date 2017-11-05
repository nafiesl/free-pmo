<?php

namespace App\Entities;

use App\Exceptions\ReferenceKeyNotFoundException;
use Illuminate\Support\Arr;

/**
 * Base of References class
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
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
        if (isset(static::$lists[$singleId])) {
            return static::$lists[$singleId];
        }

        new ReferenceKeyNotFoundException('Reference key: '.$singleId.' not found for '.get_called_class().'::lists');
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
        if (!!static::getById($colorId) && isset(static::$colors[$colorId])) {
            return static::$colors[$colorId];
        }

        throw new ReferenceKeyNotFoundException('Reference key: '.$colorId.' not found for '.get_called_class().'::colors');
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
