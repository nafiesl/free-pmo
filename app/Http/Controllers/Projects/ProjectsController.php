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
    /**
     * Projects Repository class.
     *
     * @var \App\Entities\Projects\ProjectsRepository
     */
    private $repo;

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * List of projects.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
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

    /**
     * Show create project form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', new Project());

        $customers = $this->repo->getCustomersList();

        return view('projects.create', compact('customers'));
    }

    /**
     * Create new project.
     *
     * @param  \App\Http\Requests\Projects\CreateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->authorize('create', new Project());

        $project = $this->repo->create($request->except('_token'));
        flash(__('project.created'), 'success');

        return redirect()->route('projects.show', $project);
    }

    /**
     * Show project detail page.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * Show project edit page.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $customers = $this->repo->getCustomersList();

        return view('projects.edit', compact('project', 'customers'));
    }

    /**
     * Update project data.
     *
     * @param  \App\Http\Requests\Projects\UpdateRequest  $request
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project = $this->repo->update($request->validated(), $project->id);
        flash(__('project.updated'), 'success');

        return redirect()->route('projects.edit', $project);
    }

    /**
     * Show project deletion confirmation page.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function delete(Project $project)
    {
        $this->authorize('delete', $project);

        return view('projects.delete', compact('project'));
    }

    /**
     * Delete project record from the system.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        if ($project->id == request('project_id')) {
            $this->repo->delete($project->id);
            flash(__('project.deleted'), 'success');
        } else {
            flash(__('project.undeleted'), 'danger');
        }

        return redirect()->route('projects.index');
    }

    /**
     * Project subscription list page.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function subscriptions(Project $project)
    {
        $this->authorize('view-subscriptions', $project);

        return view('projects.subscriptions', compact('project'));
    }

    /**
     * Project payment list page.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function payments(Project $project)
    {
        $this->authorize('view-payments', $project);

        $project->load('payments.partner');

        return view('projects.payments', compact('project'));
    }

    /**
     * Update project status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusUpdate(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $project = $this->repo->updateStatus($request->get('status_id'), $project->id);
        flash(__('project.updated'), 'success');

        return redirect()->route('projects.show', $project);
    }

    /**
     * Project jobs reorder action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Project  $project
     * @return string|null
     */
    public function jobsReorder(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        if ($request->expectsJson()) {
            $data = $this->repo->jobsReorder($request->get('postData'));

            return 'oke';
        }
    }
}
