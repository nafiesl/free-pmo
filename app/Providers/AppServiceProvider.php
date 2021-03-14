<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
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

        Relation::morphMap([
            'projects' => 'App\Entities\Projects\Project',
            'issues'   => 'App\Entities\Projects\Issue',
            'jobs'     => 'App\Entities\Projects\Job',
            'tasks'    => 'App\Entities\Projects\Task',
        ]);
        Paginator::useBootstrap();
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
