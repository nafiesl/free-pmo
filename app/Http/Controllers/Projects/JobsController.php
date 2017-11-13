<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\JobsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\CreateRequest;
use App\Http\Requests\Jobs\DeleteRequest;
use App\Http\Requests\Jobs\UpdateRequest;
use Illuminate\Http\Request;

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

    public function create($projectId)
    {
        $project = $this->repo->requireProjectById($projectId);
        $workers = $this->repo->getWorkersList();
        return view('jobs.create', compact('project', 'workers'));
    }

    public function addFromOtherProject(Request $req, $projectId)
    {
        $selectedProject = null;
        $project = $this->repo->requireProjectById($projectId);
        $workers = $this->repo->getWorkersList();
        $projects = $this->repo->getProjectsList();

        if ($req->has('project_id')) {
            $selectedProject = $this->repo->requireProjectById($req->get('project_id'));
        }
        return view('jobs.add-from-other-project', compact('project', 'workers', 'projects', 'selectedProject'));
    }

    public function store(CreateRequest $req, $projectId)
    {
        $job = $this->repo->createJob($req->except('_token'), $projectId);
        flash()->success(trans('job.created'));
        return redirect()->route('jobs.show', $job->id);
    }

    public function storeFromOtherProject(Request $req, $projectId)
    {
        $this->repo->createJobs($req->except('_token'), $projectId);
        flash()->success(trans('job.created_from_other_project'));
        return redirect()->route('projects.jobs', $projectId);
    }

    public function show(Request $req, $jobId)
    {
        $editableTask = null;
        $job = $this->repo->requireById($jobId);

        if ($req->get('action') == 'task_edit' && $req->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($req->get('task_id'));
        }

        if ($req->get('action') == 'task_delete' && $req->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($req->get('task_id'));
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

        return redirect()->route('projects.jobs', $projectId);
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
