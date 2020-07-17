<?php

namespace App\Entities;

use App\Exceptions\ReferenceKeyNotFoundException;
use Illuminate\Support\Arr;

/**
 * Base of References class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
abstract class ReferenceAbstract
{
    /**
     * List of reference items.
     *
     * @var array
     */
    protected static $lists = [];

    /**
     * List of color of reference items.
     *
     * @var array
     */
    protected static $colors = [];

    /**
     * Get collection of items.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function get()
    {
        return collect(static::$lists);
    }

    /**
     * Get array of items.
     *
     * @return array
     */
    public static function toArray()
    {
        return static::$lists;
    }

    /**
     * Get array of items.
     *
     * @return array
     */
    public static function all()
    {
        return static::toArray();
    }

    /**
     * Get item value by id (index).
     *
     * @param  int|string  $singleId
     * @return string
     */
    public static function getById($singleId)
    {
        if (isset(static::$lists[$singleId])) {
            return static::$lists[$singleId];
        }

        new ReferenceKeyNotFoundException('Reference key: '.$singleId.' not found for '.get_called_class().'::lists');
    }

    /**
     * Return array of items by array of ids (indexes).
     *
     * @param  array  $singleIds
     * @return array
     */
    public static function only(array $singleIds)
    {
        return Arr::only(static::$lists, $singleIds);
    }

    /**
     * Return array of items except given ids (indexes).
     *
     * @param  array  $singleIds
     * @return array
     */
    public static function except(array $singleIds)
    {
        return Arr::except(static::$lists, $singleIds);
    }

    /**
     * List of item colors.
     *
     * @return array
     */
    public static function colors()
    {
        return static::$colors;
    }

    /**
     * Get color name by item id (index).
     *
     * @param  int|string  $colorId
     * @return string
     */
    public static function getColorById($colorId)
    {
        if ((bool) static::getById($colorId) && isset(static::$colors[$colorId])) {
            return static::$colors[$colorId];
        }

        throw new ReferenceKeyNotFoundException('Reference key: '.$colorId.' not found for '.get_called_class().'::colors');
    }

    /**
     * Return array of item colors except given for ids (indexes).
     *
     * @param  array  $colorIds
     * @return array
     */
    public static function colorsExcept(array $colorIds)
    {
        return Arr::except(static::$colors, $colorIds);
    }

    /**
     * Return array of item colorss by array of ids (indexes).
     *
     * @param  array  $colorIds
     * @return array
     */
    public static function colorsOnly(array $colorIds)
    {
        return Arr::only(static::$colors, $colorIds);
    }
}
