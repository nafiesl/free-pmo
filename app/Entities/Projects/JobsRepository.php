<?php

namespace App\Entities\Projects;

use App\Entities\BaseRepository;
use App\Entities\Users\User;
use App\Queries\AdminDashboardQuery;
use DB;

/**
 * Jobs Repository.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Job $model)
    {
        parent::__construct($model);
    }

    public function getUnfinishedJobs(User $user, $projectId = null)
    {
        return (new AdminDashboardQuery())
            ->onProgressJobs($user, ['project', 'worker'], $projectId);
    }

    public function requireProjectById($projectId)
    {
        return Project::findOrFail($projectId);
    }

    public function createJob($jobData, $projectId)
    {
        $jobData['project_id'] = $projectId;

        return $this->storeArray($jobData);
    }

    public function createJobs($jobsData, $projectId)
    {
        $selectedJobs = $this->model->whereIn('id', $jobsData['job_ids'])->get();

        DB::beginTransaction();
        foreach ($selectedJobs as $job) {
            $newJob = $job->replicate();
            $newJob->project_id = $projectId;
            $newJob->save();

            if (isset($jobsData[$job->id.'_task_ids'])) {
                $selectedTasks = $job->tasks()->whereIn('id', $jobsData[$job->id.'_task_ids'])->get();

                foreach ($selectedTasks as $task) {
                    $newTask = $task->replicate();
                    $newTask->progress = 0;
                    $newTask->job_id = $newJob->id;
                    $newTask->save();
                }
            }
        }
        DB::commit();

        return 'ok';
    }

    public function getTasksByJobId($jobId)
    {
        return Task::whereJobId($jobId)->get();
    }

    public function requireTaskById($taskId)
    {
        return Task::findOrFail($taskId);
    }

    public function update($jobData, $jobId)
    {
        foreach ($jobData as $key => $value) {
            if (!$jobData[$key]) {
                $jobData[$key] = null;
            }
        }

        $jobData['price'] = str_replace('.', '', $jobData['price']);
        $job = $this->requireById($jobId);
        $job->update($jobData);

        return $job;
    }

    public function tasksReorder($sortedData)
    {
        $taskOrder = explode(',', $sortedData);

        foreach ($taskOrder as $order => $taskId) {
            $task = $this->requireTaskById($taskId);
            $task->position = $order + 1;
            $task->save();
        }

        return $taskOrder;
    }
}
