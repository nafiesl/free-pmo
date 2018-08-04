<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * Display a listing of the project comments.
     *
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\View\View
     */
    public function index(Project $project)
    {
        $comments = $project->comments()->latest()->paginate();

        return view('projects.comments', compact('project', 'comments'));
    }

    /**
     * Store a new comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $newComment = $request->validate([
            'body'         => 'required|string|max:255',
            'fu_type_id'   => 'nullable|numeric',
            'objection_id' => 'nullable|numeric',
        ]);

        $project->comments()->create([
            'body'       => $newComment['body'],
            'creator_id' => auth()->id(),
        ]);

        flash(__('comment.created'), 'success');

        return back();
    }
}
