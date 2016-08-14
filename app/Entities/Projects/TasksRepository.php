<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;

/**
* Tasks Repository Class
*/
class TasksRepository extends BaseRepository
{
    protected $model;

    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function createTask($taskData, $featureId)
    {
        $taskData['feature_id'] = $featureId;
        return $this->storeArray($taskData);
    }

    public function getTasksByFeatureId($featureId)
    {
        return Task::whereTaskId($featureId)->get();
    }
}