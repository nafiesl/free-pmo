<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Entities\Projects\Comment;
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
        $editableComment = null;
        $comments = $project->comments()->latest()->paginate();

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }

        return view('projects.comments', compact('project', 'comments', 'editableComment'));
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
            'body' => 'required|string|max:255',
        ]);

        $project->comments()->create([
            'body'       => $newComment['body'],
            'creator_id' => auth()->id(),
        ]);

        flash(__('comment.created'), 'success');

        return back();
    }

    /**
     * Update the specified comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Project  $project
     * @param  \App\Entities\Projects\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Comment $comment)
    {
        $commentData = $request->validate([
            'body' => 'required|string|max:255',
        ]);
        $comment->update($commentData);
        flash(__('comment.updated'), 'success');

        return redirect()->route('projects.comments.index', [$project] + request(['page']));
    }
}
