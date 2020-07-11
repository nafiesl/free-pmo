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
        $jobs = $project->jobs()->with(['tasks', 'worker'])->get();

        return view('projects.jobs.index', compact('project', 'jobs'));
    }

    public function create(Project $project)
    {
        $workers = $this->repo->getWorkersList();

        return view('projects.jobs.create', compact('project', 'workers'));
    }

    public function addFromOtherProject(Request $request, Project $project)
    {
        $selectedProject = null;
        $workers = $this->repo->getWorkersList();
        $projects = $this->getProjectsList();

        if ($request->has('project_id')) {
            $selectedProject = Project::find($request->get('project_id'));
        }

        return view('projects.jobs.add-from-other-project', compact('project', 'workers', 'projects', 'selectedProject'));
    }

    public function store(CreateRequest $req, $projectId)
    {
        $job = $this->repo->createJob($req->except('_token'), $projectId);
        flash(__('job.created'), 'success');

        return redirect()->route('jobs.show', $job->id);
    }

    public function storeFromOtherProject(Request $request, $projectId)
    {
        $request->validate(['job_ids' => 'required|array']);

        $this->repo->createJobs($request->except('_token'), $projectId);

        flash(__('job.created_from_other_project'), 'success');

        return redirect()->route('projects.jobs.index', $projectId);
    }

    public function jobsExport(Project $project, $exportType = 'html')
    {
        $jobs = $project->getJobList(request('job_type', 1));

        return view('projects.jobs.export-html', compact('project', 'jobs'));
    }

    public function jobProgressExport(Project $project, $exportType = 'html')
    {
        $jobs = $project->getJobList(request('job_type', 1));

        return view('projects.jobs.progress-export-html', compact('project', 'jobs'));
    }
}
