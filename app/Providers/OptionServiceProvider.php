<?php

namespace App\Providers;

use App\Services\Option;
use Illuminate\Support\ServiceProvider;

/**
 * Option Service Provider.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class OptionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias(Option::class, 'option');
    }
}
