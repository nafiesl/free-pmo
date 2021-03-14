<?php

namespace App\Listeners\Jobs;

use App\Entities\Users\Activity;
use App\Events\Jobs\Updated;

class LogJobUpdateActivity
{
    public function handle(Updated $event)
    {
        $job = $event->job;
        $originalJob = $job->getOriginal();
        $attributeChanges = $job->getChanges();
        $attributeKeys = array_keys($job->getChanges());

        $activityEntry = [
            'type'        => 'job_updated',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $job->id,
            'object_type' => 'jobs',
            'data'        => [
                'before' => $this->getBeforeValues($originalJob, $attributeKeys),
                'after'  => $this->getAfterValues($job->toArray(), $attributeKeys),
                'notes'  => null,
            ],
        ];

        Activity::create($activityEntry);
    }

    private function getBeforeValues(array $originalJob, array $attributeKeys)
    {
        $beforeValues = [];
        foreach ($attributeKeys as $attributeKey) {
            $beforeValues[$attributeKey] = $originalJob[$attributeKey];
        }

        return $beforeValues;
    }

    private function getAfterValues(array $job, array $attributeKeys)
    {
        $afterValues = [];
        foreach ($attributeKeys as $attributeKey) {
            $afterValues[$attributeKey] = $job[$attributeKey];
        }

        return $afterValues;
    }
}
