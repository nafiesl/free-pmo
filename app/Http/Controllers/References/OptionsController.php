<?php

namespace App\Http\Controllers\References;

use App\Http\Requests\Options\CreateRequest;
use App\Http\Requests\Options\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Entities\Options\OptionsRepository;

use Illuminate\Http\Request;

class OptionsController extends Controller {

	private $repo;

	public function __construct(OptionsRepository $repo)
	{
	    $this->repo = $repo;
	}

	public function index(Request $req)
	{
		$options = $this->repo->getAll();
		return view('options.index',compact('options'));
	}

	public function create()
	{
		return view('options.create');
	}

	public function store(CreateRequest $req)
	{
		$option = $this->repo->create($req->except('_token'));
		flash()->success(trans('option.created'));
		return redirect()->route('options.index');
	}

	public function delete($optionId)
	{
	    $option = $this->repo->requireById($optionId);
		return view('options.delete', compact('option'));
	}

	public function destroy(Request $req, $optionId)
	{
		if ($optionId == $req->get('option_id'))
		{
			$this->repo->delete($optionId);
	        flash()->success(trans('option.deleted'));
		}
		else
			flash()->error(trans('option.undeleted'));

		return redirect()->route('options.index');
	}

	public function save(Request $req)
	{
		$this->repo->save($req->except(['_method','_token']));
		flash()->success(trans('option.updated'));
		return redirect()->route('options.index');
	}

}
