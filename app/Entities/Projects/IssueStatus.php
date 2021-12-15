<?php

namespace App\Entities\Projects;

use App\Entities\ReferenceAbstract;

class IssueStatus extends ReferenceAbstract
{
    protected static $lists = [
        0 => 'open',
        1 => 'resolved',
        2 => 'closed',
        3 => 'on_hold',
        4 => 'invalid',
    ];

    protected static $colors = [
        0 => 'yellow',
        1 => 'green',
        2 => 'primary',
        3 => 'default',
        4 => 'warning',
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
