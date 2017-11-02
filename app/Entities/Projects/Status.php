<?php

namespace App\Entities\Projects;

use App\Entities\ReferenceAbstract;

class Status extends ReferenceAbstract
{
    protected static $lists = [
        1 => 'planned',
        2 => 'progress',
        3 => 'done',
        4 => 'closed',
        5 => 'canceled',
        6 => 'on_hold',
    ];

    public static function getNameById($singleId)
    {
        return trans('project.'.static::$lists[$singleId]);
    }

    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = trans('project.'.$value);
        }

        return $lists;
    }

    public static function all()
    {
        return collect($this->toArray());
    }
}
