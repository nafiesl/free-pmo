<?php

namespace App\Http\Controllers\Issues;

use App\Entities\Projects\Comment;
use App\Entities\Projects\Issue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a new comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Issue  $issue
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Issue $issue)
    {
        $this->authorize('comment-on', $issue);

        $newComment = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $issue->comments()->create([
            'body'       => $newComment['body'],
            'creator_id' => auth()->id(),
        ]);
        $issue->touch();

        flash(__('comment.created'), 'success');

        return back();
    }

    /**
     * Update the specified comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Issue  $issue
     * @param  \App\Entities\Projects\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue, Comment $comment)
    {
        $this->authorize('update', $comment);

        $commentData = $request->validate([
            'body' => 'required|string|max:255',
        ]);
        $comment->update($commentData);
        flash(__('comment.updated'), 'success');

        return redirect()->route('projects.issues.show', [$issue->project, $issue]);
    }

    /**
     * Remove the specified comment.
     *
     * @param  \App\Entities\Projects\Issue  $issue
     * @param  \\App\Entities\Projects\Comment  $comment
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Issue $issue, Comment $comment)
    {
        $this->authorize('delete', $comment);

        request()->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        if (request('comment_id') == $comment->id && $comment->delete()) {
            flash(__('comment.deleted'), 'warning');

            return redirect()->route('projects.issues.show', [$issue->project, $issue]);
        }
        flash(__('comment.undeleted'), 'error');

        return back();
    }
}
