<?php

namespace App\Http\Middleware;

use App\Entities\Projects\Project;
use Closure;
use DB;

class GlobalViewVariables
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $projectsCount = Project::select(DB::raw('status_id, count(id) as count'))
            ->groupBy('status_id')
            ->pluck('count', 'status_id')
            ->all();

        view()->share('sidebarProjectStats', $projectsCount);

        return $next($request);
    }
}
