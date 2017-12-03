<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;

/**
 * Tasks Repository Class.
 */
class TasksRepository extends BaseRepository
{
    protected $model;

    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function createTask($taskData, $jobId)
    {
        $taskData['job_id'] = $jobId;

        return $this->storeArray($taskData);
    }

    public function getTasksByJobId($jobId)
    {
        return Task::whereTaskId($jobId)->get();
    }
}
