<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Job;
use App\Entities\Projects\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\CreateRequest;
use App\Http\Requests\Tasks\DeleteRequest;
use App\Http\Requests\Tasks\UpdateRequest;
use DB;

/**
 * Project Tasks Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class TasksController extends Controller
{
    /**
     * Store a created job task to the database.
     *
     * @param  \App\Http\Requests\Tasks\CreateRequest  $request
     * @param  \App\Entities\Projects\Job  $job
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request, Job $job)
    {
        $newTask = $request->validated();
        $newTask['job_id'] = $job->id;
        $task = Task::create($newTask);

        flash(__('task.created'), 'success');

        return redirect()->route('jobs.show', $job);
    }

    /**
     * Update a task on the database.
     *
     * @param  \App\Http\Requests\Tasks\UpdateRequest  $request
     * @param  \App\Entities\Projects\Task  $task
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        flash(__('task.updated'), 'success');

        return redirect()->route('jobs.show', $task->job_id);
    }

    /**
     * Delete task from the database.
     *
     * @param  \App\Http\Requests\Tasks\DeleteRequest  $request
     * @param  \App\Entities\Projects\Task  $task
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(DeleteRequest $request, Task $task)
    {
        if ($task->id == $request->get('task_id')) {
            $task->delete();
            flash(__('task.deleted'), 'success');
        } else {
            flash(__('task.undeleted'), 'danger');
        }

        return redirect()->route('jobs.show', $task->job_id);
    }

    /**
     * Set a task to become a job.
     *
     * @param  \App\Entities\Projects\Task  $task
     * @return \Illuminate\Routing\Redirector
     */
    public function setAsJob(Task $task)
    {
        $oldJob = $task->job;

        $job = new Job;
        $job->name = $task->name;
        $job->description = $task->description;
        $job->project_id = $oldJob->project_id;
        $job->worker_id = $oldJob->worker_id;

        DB::beginTransaction();
        $job->save();
        $task->delete();
        DB::commit();

        flash(__('task.upgraded_as_job'), 'success');

        return redirect()->route('jobs.edit', $job);
    }

    public function setDone(Task $task)
    {
        $task->progress = 100;
        $task->save();

        flash(__('task.updated'), 'success');

        return redirect()->route('jobs.show', $task->job);
    }
}
