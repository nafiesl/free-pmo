<?php

namespace App\Entities\Projects;

use App\Entities\ReferenceAbstract;
use App\Exceptions\ReferenceKeyNotFoundException;

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

    protected static $colors = [
        1 => 'default',
        2 => 'yellow',
        3 => 'primary',
        4 => 'green',
        5 => 'danger',
        6 => 'warning',
    ];

    protected static $icons = [
        1 => 'paperclip',
        2 => 'tasks',
        3 => 'thumbs-o-up',
        4 => 'money',
        5 => 'frown-o',
        6 => 'hand-paper-o',
    ];

    public static function getNameById($singleId)
    {
        return __('project.'.static::getById($singleId));
    }

    public static function getIconById($singleId)
    {
        if ((bool) static::getById($singleId) && isset(static::$icons[$singleId])) {
            return static::$icons[$singleId];
        }

        throw new ReferenceKeyNotFoundException('Reference key: '.$singleId.' not found for '.get_called_class().'::icons');
    }

    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = __('project.'.$value);
        }

        return $lists;
    }
}
