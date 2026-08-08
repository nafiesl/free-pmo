<?php

namespace App\Http\Controllers\Api;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectCommentsController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('viewComments', $project);

        return $project->comments()->with('creator')->latest()->get();
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('commentOn', $project);

        $comment = $project->comments()->create([
            'body' => $request->validate(['body' => 'required|string|max:255'])['body'],
            'creator_id' => auth()->id(),
        ]);

        return response()->json(['message' => __('comment.created'), 'id' => $comment->id], 201);
    }

    public function update(Request $request, Project $project, Comment $comment)
    {
        $this->authorize('update', $comment);

        if ($comment->commentable_id != $project->id || $comment->commentable_type != (new Project)->getMorphClass()) {
            abort(404);
        }

        $comment->update($request->validate(['body' => 'required|string|max:255']));

        return response()->json(['message' => __('comment.updated')], 200);
    }

    public function destroy(Project $project, Comment $comment)
    {
        $this->authorize('delete', $comment);

        if ($comment->commentable_id != $project->id || $comment->commentable_type != (new Project)->getMorphClass()) {
            abort(404);
        }

        $comment->delete();

        return response()->json(['message' => __('comment.deleted')], 200);
    }
}
