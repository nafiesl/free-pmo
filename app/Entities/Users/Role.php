<?php

namespace App\Entities\Users;

use App\Entities\ReferenceAbstract;

/**
 * Role Class
 */
class Role extends ReferenceAbstract
{
    protected static $lists = [
        1 => 'admin',
        2 => 'worker',
    ];

    public static function getNameById($roleId)
    {
        return trans('user.roles.'.static::$lists[$roleId]);
    }

    public static function getIdByName($roleName)
    {
        return array_search($roleName, static::$lists);
    }

    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = trans('user.roles.'.$value);
        }

        return $lists;
    }
}
