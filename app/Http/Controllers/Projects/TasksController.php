<?php

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Tasks\CreateRequest;
use App\Http\Requests\Tasks\UpdateRequest;
use App\Http\Requests\Tasks\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Entities\Projects\TasksRepository;

use Illuminate\Http\Request;

class TasksController extends Controller {

	private $repo;

	public function __construct(TasksRepository $repo)
	{
	    $this->repo = $repo;
	}

	public function store(CreateRequest $req, $featureId)
	{
		$feature = $this->repo->createTask($req->except('_token'), $featureId);
		flash()->success(trans('task.created'));
		return redirect()->route('features.show', $featureId);
	}

	public function update(UpdateRequest $req, $taskId)
	{
		$task = $this->repo->update($req->except(['_method','_token']), $taskId);
		flash()->success(trans('task.updated'));
		return redirect()->route('features.show', $task->feature_id);
	}

	public function destroy(DeleteRequest $req, $taskId)
	{
	    $task = $this->repo->requireById($taskId);
	    $featureId = $task->feature_id;

		if ($taskId == $req->get('task_id'))
		{
			$task->delete();
	        flash()->success(trans('task.deleted'));
		}
		else
			flash()->error(trans('task.undeleted'));

		return redirect()->route('features.show', $featureId);
	}

}
