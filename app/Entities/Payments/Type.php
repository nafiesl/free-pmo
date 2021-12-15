<?php

namespace App\Entities\Payments;

use App\Entities\ReferenceAbstract;

class Type extends ReferenceAbstract
{
    protected static $lists = [
        1 => 'project',
        2 => 'add_job',
        3 => 'maintenance',
    ];

    protected static $colors = [
        1 => '#337ab7',
        2 => '#4caf50',
        3 => '#ff8181',
    ];

    public static function getNameById($singleId)
    {
        return __('payment.types.'.static::getById($singleId));
    }

    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = __('payment.types.'.$value);
        }

        return $lists;
    }
}
