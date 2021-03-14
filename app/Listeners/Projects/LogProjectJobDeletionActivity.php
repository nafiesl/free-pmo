<?php

namespace App\Listeners\Projects;

use App\Entities\Users\Activity;
use App\Events\Jobs\Deleted;

class LogProjectJobDeletionActivity
{
    public function handle(Deleted $event)
    {
        $job = $event->job;
        $projectId = $job->project_id;

        $activityEntry = [
            'type'        => 'job_deleted',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $projectId,
            'object_type' => 'projects',
            'data'        => [
                'name'        => $job->name,
                'description' => $job->description,
                'price'       => $job->price,
            ],
        ];

        Activity::create($activityEntry);
    }
}
