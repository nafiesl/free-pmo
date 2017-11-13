<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\TasksRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\CreateRequest;
use App\Http\Requests\Tasks\DeleteRequest;
use App\Http\Requests\Tasks\UpdateRequest;

class TasksController extends Controller
{

    private $repo;

    public function __construct(TasksRepository $repo)
    {
        $this->repo = $repo;
    }

    public function store(CreateRequest $req, $jobId)
    {
        $job = $this->repo->createTask($req->except('_token'), $jobId);
        flash()->success(trans('task.created'));
        return redirect()->route('jobs.show', $jobId);
    }

    public function update(UpdateRequest $req, $taskId)
    {
        $task = $this->repo->update($req->except(['_method', '_token']), $taskId);
        flash()->success(trans('task.updated'));
        return redirect()->route('jobs.show', $task->job_id);
    }

    public function destroy(DeleteRequest $req, $taskId)
    {
        $task = $this->repo->requireById($taskId);
        $jobId = $task->job_id;

        if ($taskId == $req->get('task_id')) {
            $task->delete();
            flash()->success(trans('task.deleted'));
        } else {
            flash()->error(trans('task.undeleted'));
        }

        return redirect()->route('jobs.show', $jobId);
    }

}
