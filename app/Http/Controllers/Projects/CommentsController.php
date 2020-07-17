<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $this->authorize('view-comments', $project);

        $editableComment = null;
        $comments = $project->comments()->with('creator')->latest()->paginate();

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
        $this->authorize('comment-on', $project);

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
        $this->authorize('update', $comment);

        $commentData = $request->validate([
            'body' => 'required|string|max:255',
        ]);
        $comment->update($commentData);
        flash(__('comment.updated'), 'success');

        return redirect()->route('projects.comments.index', [$project] + request(['page']));
    }

    /**
     * Remove the specified comment.
     *
     * @param  \App\Entities\Projects\Comment  $comment
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Project $project, Comment $comment)
    {
        $this->authorize('delete', $comment);

        request()->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        if (request('comment_id') == $comment->id && $comment->delete()) {
            $routeParam = [$project] + request(['page']);
            flash(__('comment.deleted'), 'warning');

            return redirect()->route('projects.comments.index', $routeParam);
        }
        flash(__('comment.undeleted'), 'error');

        return back();
    }
}
