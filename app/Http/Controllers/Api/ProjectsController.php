<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Projects\ProjectsRepository;

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

    public function show($id)
    {
        return $this->repo->requireById($id);
    }

    public function jobs($id)
    {
        $project = $this->repo->requireById($id);
        // $project->load('jobs.tasks');
        $response = fractal()
            ->item($project->toArray())
            ->transformWith(function ($project) {
                return $project;
            })
            ->toArray();

        return $response;
    }
}
