<?php

namespace App\Http\Controllers\Projects;

use App\Http\Requests\Projects\CreateRequest;
use App\Http\Requests\Projects\UpdateRequest;
use App\Http\Requests\Projects\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Entities\Projects\ProjectsRepository;

use Illuminate\Http\Request;

class ProjectsController extends Controller {

	private $repo;

	public function __construct(ProjectsRepository $repo)
	{
	    $this->repo = $repo;
	}

	public function index(Request $req)
	{
		$status = null;
		$statusId = $req->get('status');
		if ($statusId) {
			$status = $this->repo->getStatusName($statusId);
		}

		$projects = $this->repo->getProjects($req->get('q'), $statusId);
		return view('projects.index',compact('projects','status'));
	}

	public function create()
	{
		$customers = $this->repo->getCustomersList();
		return view('projects.create', compact('customers'));
	}

	public function store(CreateRequest $req)
	{
		$project = $this->repo->create($req->except('_token'));
		flash()->success(trans('project.created'));
		return redirect()->route('projects.show', $project->id);
	}

	public function show($projectId)
	{
		$project = $this->repo->requireById($projectId);
		return view('projects.show', compact('project'));
	}

	public function edit($projectId)
	{
		$project = $this->repo->requireById($projectId);
		$statuses = getProjectStatusesList();
		$customers = $this->repo->getCustomersList();
		return view('projects.edit',compact('project','statuses','customers'));
	}

	public function update(UpdateRequest $req, $projectId)
	{
		$project = $this->repo->update($req->except(['_method','_token']), $projectId);
		flash()->success(trans('project.updated'));
		return redirect()->route('projects.edit', $projectId);
	}

	public function delete($projectId)
	{
	    $project = $this->repo->requireById($projectId);
		return view('projects.delete', compact('project'));
	}

	public function destroy(DeleteRequest $req, $projectId)
	{
		if ($projectId == $req->get('project_id'))
		{
			$this->repo->delete($projectId);
	        flash()->success(trans('project.deleted'));
		}
		else
			flash()->error(trans('project.undeleted'));

		return redirect()->route('projects.index');
	}

	public function features($projectId)
	{
	    $project = $this->repo->requireById($projectId);
	    $features = $this->repo->getProjectFeatures($projectId);
		return view('projects.features', compact('project','features'));
	}

	public function payments($projectId)
	{
	    $project = $this->repo->requireById($projectId);
	    $project->load('payments.customer');
		return view('projects.payments', compact('project'));
	}

	public function statusUpdate(Request $req, $projectId)
	{
		$project = $this->repo->updateStatus($req->get('status_id'), $projectId);
		flash()->success(trans('project.updated'));
		return redirect()->route('projects.show', $projectId);
	}

}
