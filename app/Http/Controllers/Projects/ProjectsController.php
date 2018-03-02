<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Project;
use App\Entities\Projects\ProjectsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\CreateRequest;
use App\Http\Requests\Projects\UpdateRequest;
use Illuminate\Http\Request;

/**
 * Projects Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ProjectsController extends Controller
{
    private $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $status = null;
        $statusId = $request->get('status_id');
        if ($statusId) {
            $status = $this->repo->getStatusName($statusId);
        }

        $projects = $this->repo->getProjects($request->get('q'), $statusId, auth()->user());

        return view('projects.index', compact('projects', 'status', 'statusId'));
    }

    public function create()
    {
        $this->authorize('create', new Project());

        $customers = $this->repo->getCustomersList();

        return view('projects.create', compact('customers'));
    }

    public function store(CreateRequest $request)
    {
        $this->authorize('create', new Project());

        $project = $this->repo->create($request->except('_token'));
        flash()->success(trans('project.created'));

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $customers = $this->repo->getCustomersList();

        return view('projects.edit', compact('project', 'customers'));
    }

    public function update(UpdateRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project = $this->repo->update($request->except(['_method', '_token']), $project->id);
        flash()->success(trans('project.updated'));

        return redirect()->route('projects.edit', $project);
    }

    public function delete(Project $project)
    {
        $this->authorize('delete', $project);

        return view('projects.delete', compact('project'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        if ($project->id == request('project_id')) {
            $this->repo->delete($project->id);
            flash()->success(trans('project.deleted'));
        } else {
            flash()->error(trans('project.undeleted'));
        }

        return redirect()->route('projects.index');
    }

    public function subscriptions(Project $project)
    {
        $this->authorize('view-subscriptions', $project);

        return view('projects.subscriptions', compact('project'));
    }

    public function payments(Project $project)
    {
        $this->authorize('view-payments', $project);

        $project->load('payments.partner');

        return view('projects.payments', compact('project'));
    }

    public function statusUpdate(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $project = $this->repo->updateStatus($request->get('status_id'), $project->id);
        flash()->success(trans('project.updated'));

        return redirect()->route('projects.show', $project);
    }

    public function jobsReorder(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        if ($request->ajax()) {
            $data = $this->repo->jobsReorder($request->get('postData'));

            return 'oke';
        }
    }
}
