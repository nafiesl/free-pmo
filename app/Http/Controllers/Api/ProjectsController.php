<?php

namespace App\Http\Controllers\Api;

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

    public function show($id)
    {
        return $this->repo->requireById($id);
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
