<?php

namespace App\Listeners\Projects;

use App\Entities\Users\Activity;
use App\Events\Projects\Updated;

class LogProjectUpdateActivity
{
    public function handle(Updated $event)
    {
        $project = $event->project;
        $originalProject = $project->getOriginal();
        $attributeChanges = $project->getChanges();
        $attributeKeys = array_keys($project->getChanges());

        $activityEntry = [
            'type'        => 'project_updated',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $project->id,
            'object_type' => 'projects',
            'data'        => [
                'before' => $this->getBeforeValues($originalProject, $attributeKeys),
                'after'  => $this->getAfterValues($project->toArray(), $attributeKeys),
                'notes'  => null,
            ],
        ];

        Activity::create($activityEntry);
    }

    private function getBeforeValues(array $originalProject, array $attributeKeys)
    {
        $beforeValues = [];
        foreach ($attributeKeys as $attributeKey) {
            $beforeValues[$attributeKey] = $originalProject[$attributeKey];
        }

        return $beforeValues;
    }

    private function getAfterValues(array $project, array $attributeKeys)
    {
        $afterValues = [];
        foreach ($attributeKeys as $attributeKey) {
            $afterValues[$attributeKey] = $project[$attributeKey];
        }

        return $afterValues;
    }
}
