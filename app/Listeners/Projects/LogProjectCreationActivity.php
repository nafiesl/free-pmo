<?php

namespace App\Listeners\Projects;

use App\Entities\Users\Activity;
use App\Events\Projects\Created;

class LogProjectCreationActivity
{
    public function handle(Created $event)
    {
        $project = $event->project;

        $activityEntry = [
            'type'        => 'project_created',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $project->id,
            'object_type' => 'projects',
        ];

        Activity::create($activityEntry);
    }
}
