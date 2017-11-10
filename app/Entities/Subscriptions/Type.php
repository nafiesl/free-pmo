<?php

namespace App\Entities\Subscriptions;

use App\Entities\ReferenceAbstract;

class Type extends ReferenceAbstract
{
    protected static $lists = [
        1 => 'domain',
        2 => 'hosting',
    ];

    protected static $colors = [
        1 => '#337ab7',
        2 => '#4caf50',
    ];

    public static function getNameById($singleId)
    {
        return trans('subscription.types.'.static::getById($singleId));
    }

    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = trans('subscription.types.'.$value);
        }

        return $lists;
    }
}
