<?php

namespace App\Listeners\Tasks;

use App\Entities\Users\Activity;
use App\Events\Tasks\Created;

class LogTaskCreationActivity
{
    public function handle(Created $event)
    {
        $task = $event->task;

        $activityEntry = [
            'type'        => 'task_created',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $task->id,
            'object_type' => 'tasks',
            'data'        => null,
        ];

        Activity::create($activityEntry);
    }
}
