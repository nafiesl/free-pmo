<?php

namespace App\Services;

use App\Entities\Options\Option as SiteOption;
use Cache;

/**
* Option Class (Site Option Service)
*/
class Option
{

    protected $option;

    public function __construct()
    {
        // if (Cache::has('option_all')) {
        //     $this->option = Cache::get('option_all');
        // } else {
        //     $this->option = SiteOption::all();
        //     Cache::put('option_all', $this->option, 60);
        // }
        $this->option = SiteOption::all();
    }

    public function get($key, $default = '')
    {
        $option = $this->option->where('key', $key)->first();
        if ($option) {
            return $option->value;
        }
        return $default;
    }
}