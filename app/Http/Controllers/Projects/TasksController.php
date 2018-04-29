<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Job;
use App\Entities\Projects\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\CreateRequest;
use App\Http\Requests\Tasks\DeleteRequest;
use App\Http\Requests\Tasks\UpdateRequest;

/**
 * Project Tasks Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class TasksController extends Controller
{
    public function store(CreateRequest $request, Job $job)
    {
        $newTask = $request->validated();
        $newTask['job_id'] = $job->id;
        $task = Task::create($newTask);

        flash(trans('task.created'), 'success');

        return redirect()->route('jobs.show', $job);
    }

    public function update(UpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        flash(trans('task.updated'), 'success');

        return redirect()->route('jobs.show', $task->job_id);
    }

    public function destroy(DeleteRequest $request, Task $task)
    {
        if ($task->id == $request->get('task_id')) {
            $task->delete();
            flash(trans('task.deleted'), 'success');
        } else {
            flash(trans('task.undeleted'), 'danger');
        }

        return redirect()->route('jobs.show', $task->job_id);
    }
}
