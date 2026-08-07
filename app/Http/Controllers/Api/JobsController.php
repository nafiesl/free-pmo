<?php

namespace App\Http\Controllers\Api;

use App\Entities\Projects\Job;
use App\Entities\Projects\JobsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    private $repo;

    public function __construct(JobsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $jobQuery = Job::query()->with('project', 'worker', 'tasks');

        if ($request->project_id) {
            $jobQuery->where('project_id', $request->project_id);
        }

        $jobs = $jobQuery->latest()->paginate();

        $response = fractal()->collection($jobs)
            ->transformWith(function ($job) {
                return [
                    'id' => $job->id,
                    'name' => $job->name,
                    'project_name' => $job->project->name,
                    'worker_name' => optional($job->worker)->name,
                    'price' => $job->price,
                    'progress' => $job->progress,
                    'position' => $job->position,
                ];
            })->toArray();

        return response()->json($response, 200);
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);

        return $job->load('project', 'worker', 'tasks', 'comments.creator');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Job);

        $jobData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'worker_id' => 'required|exists:users,id',
            'price' => 'nullable|numeric',
            'type_id' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $job = $this->repo->createJob($jobData, $request->project_id);

        return response()->json(['message' => __('job.created'), 'id' => $job->id], 201);
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $job->update($request->validate([
            'name' => 'sometimes|string|max:255',
            'worker_id' => 'sometimes|exists:users,id',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
        ]));

        return response()->json(['message' => __('job.updated')], 200);
    }
}
