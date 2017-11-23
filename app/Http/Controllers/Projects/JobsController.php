<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\JobsRepository;
use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\CreateRequest;
use Illuminate\Http\Request;

/**
 * Project Jobs Controller.
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

    public function index(Project $project)
    {
        $jobs = $project->jobs;

        return view('projects.jobs.index', compact('project', 'jobs'));
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

        return redirect()->route('projects.jobs.index', $projectId);
    }

    public function jobsExport(Project $project, $exportType = 'html')
    {
        $jobs = $project->getJobList(request('job_type', 1));

        return view('projects.jobs-export-html', compact('project', 'jobs'));
    }
}
