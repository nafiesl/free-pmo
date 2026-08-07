<?php

namespace App\Http\Controllers\Api;

use App\Entities\Projects\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', new Task);

        $taskData = $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $task = Task::create($taskData);

        return response()->json(['message' => __('task.created'), 'id' => $task->id], 201);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validate([
            'name' => 'sometimes|string|max:255',
            'progress' => 'sometimes|integer|min:0|max:100',
            'description' => 'sometimes|string',
        ]));

        return response()->json(['message' => __('task.updated'), 'progress' => $task->progress], 200);
    }
}
