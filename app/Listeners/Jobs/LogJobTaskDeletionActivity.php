<?php

namespace App\Listeners\Jobs;

use App\Entities\Users\Activity;
use App\Events\Tasks\Deleted;

class LogJobTaskDeletionActivity
{
    public function handle(Deleted $event)
    {
        $task = $event->task;
        $jobId = $task->job_id;

        $activityEntry = [
            'type'        => 'task_deleted',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $jobId,
            'object_type' => 'jobs',
            'data'        => [
                'name'        => $task->name,
                'description' => $task->description,
                'progress'    => $task->progress,
            ],
        ];

        Activity::create($activityEntry);
    }
}
