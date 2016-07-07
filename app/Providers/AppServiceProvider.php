<?php

namespace App\Providers;

use App\Entities\Projects\Project;
use DB;
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
        require_once app_path() . '/helpers.php';
        $projectCounts = Project::select(DB::raw('status_id, count(id) as count'))
                            ->groupBy('status_id')
                            ->lists('count','status_id')
                            ->all();
        view()->share('projectCounts', $projectCounts);
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
