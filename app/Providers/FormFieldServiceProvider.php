<?php

namespace App\Providers;

use App\Services\FormField;
use Illuminate\Support\ServiceProvider;

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
        $this->app->alias(FormField::class, 'formField');
    }
}
