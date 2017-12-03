<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\ProjectsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\CreateRequest;
use App\Http\Requests\Projects\DeleteRequest;
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
        $statusId = $request->get('status');
        if ($statusId) {
            $status = $this->repo->getStatusName($statusId);
        }

        $projects = $this->repo->getProjects($request->get('q'), $statusId);

        return view('projects.index', compact('projects', 'status'));
    }

    public function create()
    {
        $customers = $this->repo->getCustomersList();

        return view('projects.create', compact('customers'));
    }

    public function store(CreateRequest $request)
    {
        $project = $this->repo->create($request->except('_token'));
        flash()->success(trans('project.created'));

        return redirect()->route('projects.show', $project->id);
    }

    public function show($projectId)
    {
        $project = $this->repo->requireById($projectId);

        return view('projects.show', compact('project'));
    }

    public function edit($projectId)
    {
        $project = $this->repo->requireById($projectId);
        $customers = $this->repo->getCustomersList();

        return view('projects.edit', compact('project', 'customers'));
    }

    public function update(UpdateRequest $request, $projectId)
    {
        $project = $this->repo->update($request->except(['_method', '_token']), $projectId);
        flash()->success(trans('project.updated'));

        return redirect()->route('projects.edit', $projectId);
    }

    public function delete($projectId)
    {
        $project = $this->repo->requireById($projectId);

        return view('projects.delete', compact('project'));
    }

    public function destroy(DeleteRequest $request, $projectId)
    {
        if ($projectId == $request->get('project_id')) {
            $this->repo->delete($projectId);
            flash()->success(trans('project.deleted'));
        } else {
            flash()->error(trans('project.undeleted'));
        }

        return redirect()->route('projects.index');
    }

    public function subscriptions($projectId)
    {
        $project = $this->repo->requireById($projectId);

        return view('projects.subscriptions', compact('project'));
    }

    public function payments($projectId)
    {
        $project = $this->repo->requireById($projectId);
        $project->load('payments.partner');

        return view('projects.payments', compact('project'));
    }

    public function statusUpdate(Request $request, $projectId)
    {
        $project = $this->repo->updateStatus($request->get('status_id'), $projectId);
        flash()->success(trans('project.updated'));

        return redirect()->route('projects.show', $projectId);
    }

    public function jobsReorder(Request $request, $projectId)
    {
        if ($request->ajax()) {
            $data = $this->repo->jobsReorder($request->get('postData'));

            return 'oke';
        }
    }
}
