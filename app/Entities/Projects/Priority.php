<?php

namespace App\Entities\Projects;

use App\Entities\ReferenceAbstract;

class Priority extends ReferenceAbstract
{
    protected static $lists = [
        1 => 'minor',
        2 => 'major',
        3 => 'critical',
    ];

    protected static $colors = [
        1 => 'info',
        2 => 'warning',
        3 => 'danger',
    ];

    public static function getNameById($singleId)
    {
        return __('issue.'.static::getById($singleId));
    }

    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = __('issue.'.$value);
        }

        return $lists;
    }
}
