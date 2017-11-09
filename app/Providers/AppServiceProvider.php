<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require_once app_path().'/helpers.php';
        \Validator::extend('file_extension', function ($attribute, $value, $parameters, $validator) {
            return in_array($value->getClientOriginalExtension(), $parameters);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
