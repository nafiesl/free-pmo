<?php

namespace App\Services;

use App\Entities\Options\Option as SiteOption;

/**
 * Option Class (Site Option Service).
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Option
{
    /**
     * Site Option from database.
     *
     * @var Illuminate\Database\Eloquent\Collection
     */
    protected $option;

    public function __construct()
    {
        $this->option = SiteOption::all();
    }

    /**
     * Get option valie based on given key.
     *
     * @param  string  $key  The option key.
     * @param  string  $default  Default value if value not found.
     * @return string The option value from database.
     */
    public function get($key, $default = '')
    {
        $option = $this->option->where('key', $key)->first();
        if ($option) {
            return $option->value;
        }

        return $default;
    }

    /**
     * Set new value for given option key.
     *
     * @param  string  $key  The option key.
     * @param  string  $value  The option value to be saved.
     * @return string The option value.
     */
    public function set($key, ?string $value)
    {
        if (is_null($value)) {
            $value = '';
        }

        $option = $this->option->where('key', $key)->first();

        if ($option) {
            $option->value = $value;
            $option->save();
        } else {
            $option = new SiteOption();
            $option->key = $key;
            $option->value = $value;
            $option->save();
        }

        return $value;
    }
}
