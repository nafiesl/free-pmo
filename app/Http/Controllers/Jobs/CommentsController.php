<?php

namespace App\Http\Controllers\Jobs;

use Illuminate\Http\Request;
use App\Entities\Projects\Job;
use App\Entities\Projects\Comment;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * Store a new comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Projects\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Job $job)
    {
        $this->authorize('comment-on', $job);

        $newComment = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $job->comments()->create([
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
     * @param  \App\Entities\Projects\Job  $job
     * @param  \App\Entities\Jobs\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job, Comment $comment)
    {
        $this->authorize('update', $comment);

        $commentData = $request->validate([
            'body' => 'required|string|max:255',
        ]);
        $comment->update($commentData);
        flash(__('comment.updated'), 'success');

        return redirect()->route('jobs.show', [$job] + request(['page']));
    }

    /**
     * Remove the specified comment.
     *
     * @param  \App\Entities\Jobs\Comment  $comment
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Job $job, Comment $comment)
    {
        $this->authorize('delete', $comment);

        request()->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        if (request('comment_id') == $comment->id && $comment->delete()) {
            $routeParam = [$job] + request(['page']);
            flash(__('comment.deleted'), 'warning');

            return redirect()->route('jobs.show', $routeParam);
        }
        flash(__('comment.undeleted'), 'error');

        return back();
    }
}
