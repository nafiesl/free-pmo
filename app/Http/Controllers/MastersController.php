<?php

namespace App\Http\Controllers;

use App\Http\Requests\Masters\CreateRequest;
use App\Http\Requests\Masters\UpdateRequest;
use App\Http\Requests\Masters\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Entities\Masters\MastersRepository;

use Illuminate\Http\Request;

class MastersController extends Controller {

	private $repo;

	public function __construct(MastersRepository $repo)
	{
	    $this->repo = $repo;
	    $this->middleware('auth');
	}

	public function index(Request $req)
	{
		$masters = $this->repo->getAll($req->get('q'));
		return view('masters.index',compact('masters'));
	}

	public function create()
	{
		return view('masters.create');
	}

	public function store(CreateRequest $req)
	{
		$master = $this->repo->create($req->except('_token'));
		flash()->success(trans('master.created'));
		return redirect()->route('masters.edit', $master->id);
	}

	public function show($masterId)
	{
		$master = $this->repo->requireById($masterId);
		return view('masters.show', compact('master'));
	}

	public function edit($masterId)
	{
		$master = $this->repo->requireById($masterId);
		return view('masters.edit',compact('master'));
	}

	public function update(UpdateRequest $req, $masterId)
	{
		$master = $this->repo->update($req->except(['_method','_token']), $masterId);
		flash()->success(trans('master.updated'));
		return redirect()->route('masters.edit', $masterId);
	}

	public function delete($masterId)
	{
	    $master = $this->repo->requireById($masterId);
		return view('masters.delete', compact('master'));
	}

	public function destroy(DeleteRequest $req, $masterId)
	{
		if ($masterId == $req->get('master_id'))
		{
			$this->repo->delete($masterId);
	        flash()->success(trans('master.deleted'));
		}
		else
			flash()->error(trans('master.undeleted'));

		return redirect()->route('masters.index');
	}

}
