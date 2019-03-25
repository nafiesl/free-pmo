<?php

namespace App\Http\Controllers\Issues;

use Illuminate\Http\Request;
use App\Entities\Projects\Issue;
use App\Http\Controllers\Controller;

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

        flash(__('comment.created'), 'success');

        return back();
    }
}
