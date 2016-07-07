<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FormField;

class FormFieldServiceProvider extends ServiceProvider
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
        $this->app['formField'] = $this->app->share(function($app)
        {
            return new FormField();
        });
    }
}
