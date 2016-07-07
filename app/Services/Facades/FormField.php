<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class FormField extends Facade
{
    protected static function getFacadeAccessor() { return 'formField'; }
}