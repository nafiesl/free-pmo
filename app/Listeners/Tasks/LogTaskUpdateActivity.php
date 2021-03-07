<?php

namespace App\Listeners\Tasks;

use App\Entities\Users\Activity;
use App\Events\Tasks\Updated;

class LogTaskUpdateActivity
{
    public function handle(Updated $event)
    {
        $task = $event->task;
        $originalTask = $task->getOriginal();
        $attributeChanges = $task->getChanges();
        $attributeKeys = array_keys($task->getChanges());

        $activityEntry = [
            'type'        => 'task_updated',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $task->id,
            'object_type' => 'tasks',
            'data'        => [
                'before' => $this->getBeforeValues($originalTask, $attributeKeys),
                'after'  => $this->getAfterValues($task->toArray(), $attributeKeys),
                'notes'  => null,
            ],
        ];

        Activity::create($activityEntry);
    }

    private function getBeforeValues(array $originalTask, array $attributeKeys)
    {
        $beforeValues = [];
        foreach ($attributeKeys as $attributeKey) {
            $beforeValues[$attributeKey] = $originalTask[$attributeKey];
        }

        return $beforeValues;
    }

    private function getAfterValues(array $task, array $attributeKeys)
    {
        $afterValues = [];
        foreach ($attributeKeys as $attributeKey) {
            $afterValues[$attributeKey] = $task[$attributeKey];
        }

        return $afterValues;
    }
}
