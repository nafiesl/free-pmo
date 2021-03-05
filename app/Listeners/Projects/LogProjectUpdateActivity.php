<?php

namespace App\Listeners\Projects;

use App\Entities\Users\Activity;
use App\Events\Projects\Updated;

class LogProjectUpdateActivity
{
    /**
     * Handle the event.
     *
     * @param  Updated  $event
     * @return void
     */
    public function handle(Updated $event)
    {
        // dd($event->project->fresh()->toArray(), $event->project->getOriginal(), $event->project->getDirty());
        $project = $event->project;
        // dd($project->getOriginal(), $project->getChanges());
        $originalProject = $project->getOriginal();
        $attributeChanges = $project->getChanges();
        $attributeKeys = array_keys($project->getChanges());
        // dd($attributeChanges, $attributeKeys);

        $activityEntry = [
            'type'        => 'project_updated',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $project->id,
            'object_type' => 'projects',
            'data'        => json_encode([
                'before' => $this->getBeforeValues($originalProject, $attributeKeys),
                'after'  => $this->getAfterValues($project->toArray(), $attributeKeys),
                'notes'  => null,
            ]),
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
