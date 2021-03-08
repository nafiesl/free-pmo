<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Entities\Users\Activity;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index(Project $project)
    {
        $activityQuery = Activity::query();

        $activityQuery->where(function ($query) use ($project) {
            $query->where('object_id', $project->id);
            $query->where('object_type', 'projects');
        });

        $activities = $activityQuery->latest()->paginate();

        return view('projects.activities.index', compact('project', 'activities'));
    }
}
