<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        Relation::morphMap([
            'projects' => 'App\Entities\Projects\Project',
            'jobs'     => 'App\Entities\Projects\Job',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
