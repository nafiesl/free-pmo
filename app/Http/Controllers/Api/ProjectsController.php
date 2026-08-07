<?php

namespace App\Http\Controllers\Api;

use App\Entities\Projects\Project;
use App\Entities\Projects\ProjectsRepository;
use App\Http\Controllers\Controller;
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
        return $this->repo->getProjects($request->get('q'), $request->get('status_id'), auth()->user());
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Project);

        $projectData = $request->validate([
            'name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'proposal_value' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status_id' => 'nullable|integer',
        ]);

        $project = $this->repo->create($projectData);

        $response = fractal()->item($project)
            ->transformWith(function ($project) {
                return $project->toArray() + ['customer_name' => $project->customer->name];
            })->toArray();

        return response()->json(['message' => __('project.created')] + $response, 201);
    }

    public function show($id)
    {
        $project = $this->repo->requireById($id);
        $this->authorize('view', $project);

        return $project;
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validate([
            'name' => 'sometimes|string|max:255',
            'proposal_value' => 'sometimes|numeric',
            'status_id' => 'sometimes|integer',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
        ]));

        return response()->json(['message' => __('project.updated')], 200);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $this->repo->delete($project->id);

        return response()->json(['message' => __('project.deleted')], 200);
    }

    public function jobs($id)
    {
        $project = $this->repo->requireById($id);
        $response = fractal()
            ->item($project->toArray())
            ->transformWith(function ($project) {
                return $project;
            })
            ->toArray();

        return $response;
    }
}
