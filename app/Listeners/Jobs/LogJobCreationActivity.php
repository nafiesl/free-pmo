<?php

namespace App\Listeners\Jobs;

use App\Entities\Users\Activity;
use App\Events\Jobs\Created;

class LogJobCreationActivity
{
    public function handle(Created $event)
    {
        $job = $event->job;

        $activityEntry = [
            'type'        => 'job_created',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $job->id,
            'object_type' => 'jobs',
            'data'        => null,
        ];

        Activity::create($activityEntry);
    }
}
