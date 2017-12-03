<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Option facade class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Option extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'option';
    }
}
