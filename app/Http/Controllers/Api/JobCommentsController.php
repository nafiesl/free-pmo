<?php

namespace App\Http\Controllers\Api;

use App\Entities\Projects\Job;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobCommentsController extends Controller
{
    public function index(Job $job)
    {
        $this->authorize('viewComments', $job);

        return $job->comments()->with('creator')->latest()->get();
    }

    public function store(Request $request, Job $job)
    {
        $this->authorize('commentOn', $job);

        $comment = $job->comments()->create([
            'body' => $request->validate(['body' => 'required|string|max:255'])['body'],
            'creator_id' => auth()->id(),
        ]);

        return response()->json(['message' => __('comment.created'), 'id' => $comment->id], 201);
    }
}
