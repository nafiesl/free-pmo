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
        $jobs = $this->repo->getUnfinishedJobs();

        return view('jobs.unfinished', compact('jobs'));
    }

    public function show(Request $request, Job $job)
    {
        $editableTask = null;

        if ($request->get('action') == 'task_edit' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        if ($request->get('action') == 'task_delete' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        return view('jobs.show', compact('job', 'editableTask'));
    }

    public function edit($jobId)
    {
        $job = $this->repo->requireById($jobId);
        $workers = $this->repo->getWorkersList();

        return view('jobs.edit', compact('job', 'workers'));
    }

    public function update(UpdateRequest $req, $jobId)
    {
        $job = $this->repo->update($req->except(['_method', '_token']), $jobId);
        flash()->success(trans('job.updated'));

        return redirect()->route('jobs.show', $job->id);
    }

    public function delete($jobId)
    {
        $job = $this->repo->requireById($jobId);

        return view('jobs.delete', compact('job'));
    }

    public function destroy(DeleteRequest $req, $jobId)
    {
        $job = $this->repo->requireById($jobId);
        $projectId = $job->project_id;
        if ($jobId == $req->get('job_id')) {
            $job->tasks()->delete();
            $job->delete();
            flash()->success(trans('job.deleted'));
        } else {
            flash()->error(trans('job.undeleted'));
        }

        return redirect()->route('projects.jobs.index', $projectId);
    }

    public function tasksReorder(Request $req, $jobId)
    {
        if ($req->ajax()) {
            $data = $this->repo->tasksReorder($req->get('postData'));
            return 'oke';
        }

        return null;
    }
}
