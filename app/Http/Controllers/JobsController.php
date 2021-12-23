<?php

namespace App\Http\Controllers;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Job;
use App\Entities\Projects\JobsRepository;
use App\Entities\Projects\Project;
use App\Http\Requests\Jobs\DeleteRequest;
use App\Http\Requests\Jobs\UpdateRequest;
use Illuminate\Http\Request;

/**
 * Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsController extends Controller
{
    /**
     * @var \App\Entities\Projects\JobsRepository
     */
    private $repo;

    /**
     * Create new Jobs Controller.
     *
     * @param  \App\Entities\Projects\JobsRepository  $repo
     */
    public function __construct(JobsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Show unfinished job list.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $projects = Project::whereIn('status_id', [2, 3])->pluck('name', 'id');
        } else {
            $projects = $user->projects()
                ->whereIn('status_id', [2, 3])
                ->pluck('projects.name', 'projects.id');
        }

        $jobs = $this->repo->getUnfinishedJobs($user, request('project_id'));

        return view('jobs.unfinished', compact('jobs', 'projects'));
    }

    /**
     * Show a job detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Job  $job
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Job $job)
    {
        $this->authorize('view', $job);

        $editableTask = null;
        $editableComment = null;
        $comments = $job->comments()->with('creator')->latest()->paginate();

        if ($request->get('action') == 'task_edit' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        if ($request->get('action') == 'task_delete' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }

        return view('jobs.show', compact('job', 'editableTask', 'comments', 'editableComment'));
    }

    /**
     * Show a job edit form.
     *
     * @param  \App\Entities\Projects\Job  $job
     * @return \Illuminate\View\View
     */
    public function edit(Job $job)
    {
        $this->authorize('view', $job);

        $workers = $this->repo->getWorkersList();

        return view('jobs.edit', compact('job', 'workers'));
    }

    /**
     * Update a job on database.
     *
     * @param  \App\Http\Requests\Jobs\UpdateRequest  $request
     * @param  \App\Entities\Projects\Job  $job
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, Job $job)
    {
        $job = $this->repo->update($request->except(['_method', '_token']), $job->id);
        flash(__('job.updated'), 'success');

        return redirect()->route('jobs.show', $job);
    }

    /**
     * Show job delete confirmation page.
     *
     * @param  \App\Entities\Projects\Job  $job
     * @return \Illuminate\View\View
     */
    public function delete(Job $job)
    {
        return view('jobs.delete', compact('job'));
    }

    /**
     * Show job delete confirmation page.
     *
     * @param  \App\Http\Requests\Jobs\DeleteRequest  $request
     * @param  \App\Entities\Projects\Job  $job
     * @return \Illuminate\View\View
     */
    public function destroy(DeleteRequest $request, Job $job)
    {
        $projectId = $job->project_id;

        if ($job->id == $request->get('job_id')) {
            $job->tasks()->delete();
            $job->delete();
            flash(__('job.deleted'), 'success');
        } else {
            flash(__('job.undeleted'), 'danger');
        }

        return redirect()->route('projects.jobs.index', $projectId);
    }

    /**
     * Reorder job task position.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Job  $job
     * @return string|null
     */
    public function tasksReorder(Request $request, Job $job)
    {
        if ($request->expectsJson()) {
            $data = $this->repo->tasksReorder($request->get('postData'));

            return 'oke';
        }
    }
}
