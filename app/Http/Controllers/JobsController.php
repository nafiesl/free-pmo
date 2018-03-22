<?php

namespace App\Http\Controllers;

use App\Entities\Projects\Job;
use App\Entities\Projects\JobsRepository;
use App\Http\Requests\Jobs\DeleteRequest;
use App\Http\Requests\Jobs\UpdateRequest;
use Illuminate\Http\Request;

/**
 * Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsController extends Controller
{
    private $repo;

    public function __construct(JobsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $jobs = $this->repo->getUnfinishedJobs(auth()->user());

        return view('jobs.unfinished', compact('jobs'));
    }

    public function show(Request $request, Job $job)
    {
        $this->authorize('view', $job);

        $editableTask = null;

        if ($request->get('action') == 'task_edit' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        if ($request->get('action') == 'task_delete' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        return view('jobs.show', compact('job', 'editableTask'));
    }

    public function edit(Job $job)
    {
        $this->authorize('view', $job);

        $workers = $this->repo->getWorkersList();

        return view('jobs.edit', compact('job', 'workers'));
    }

    public function update(UpdateRequest $request, Job $job)
    {
        $job = $this->repo->update($request->except(['_method', '_token']), $job->id);
        flash()->success(trans('job.updated'));

        return redirect()->route('jobs.show', $job);
    }

    public function delete(Job $job)
    {
        return view('jobs.delete', compact('job'));
    }

    public function destroy(DeleteRequest $request, Job $job)
    {
        $projectId = $job->project_id;

        if ($job->id == $request->get('job_id')) {
            $job->tasks()->delete();
            $job->delete();
            flash()->success(trans('job.deleted'));
        } else {
            flash()->error(trans('job.undeleted'));
        }

        return redirect()->route('projects.jobs.index', $projectId);
    }

    public function tasksReorder(Request $request, Job $job)
    {
        if ($request->ajax()) {
            $data = $this->repo->tasksReorder($request->get('postData'));

            return 'oke';
        }
    }
}
