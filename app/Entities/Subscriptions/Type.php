<?php

namespace App\Entities\Subscriptions;

use App\Entities\ReferenceAbstract;

class Type extends ReferenceAbstract
{
    /**
     * List of subscription type item.
     *
     * @var array
     */
    protected static $lists = [
        1 => 'domain',
        2 => 'hosting',
        3 => 'maintenance',
    ];

    /**
     * List of subscription color by type.
     *
     * @var array
     */
    protected static $colors = [
        1 => '#337ab7',
        2 => '#4caf50',
        3 => '#00b3ff',
    ];

    /**
     * Get type name by id.
     *
     * @param  int  $singleId
     * @return string
     */
    public static function getNameById($singleId)
    {
        return __('subscription.types.'.static::getById($singleId));
    }

    /**
     * Get subscription type items in array format.
     *
     * @return array
     */
    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = __('subscription.types.'.$value);
        }

        return $lists;
    }
}
