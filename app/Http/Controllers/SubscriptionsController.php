<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscriptions\CreateRequest;
use App\Http\Requests\Subscriptions\UpdateRequest;
use App\Http\Requests\Subscriptions\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Entities\Subscriptions\SubscriptionsRepository;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller {

	private $repo;

	public function __construct(SubscriptionsRepository $repo)
	{
	    $this->repo = $repo;
	}

	public function index(Request $req)
	{
		$subscriptions = $this->repo->getAll($req->get('q'));
		return view('subscriptions.index',compact('subscriptions'));
	}

	public function create()
	{
		$projects = $this->repo->getProjectsList();
		$customers = $this->repo->getCustomersList();
		$vendors = $this->repo->getVendorsList();
		return view('subscriptions.create', compact('projects','customers','vendors'));
	}

	public function store(CreateRequest $req)
	{
		$subscription = $this->repo->create($req->except('_token'));
		flash()->success(trans('subscription.created'));
		return redirect()->route('subscriptions.index');
	}

	public function show($subscriptionId)
	{
		$subscription = $this->repo->requireById($subscriptionId);
		return view('subscriptions.show', compact('subscription'));
	}

	public function edit($subscriptionId)
	{
		$subscription = $this->repo->requireById($subscriptionId);
		$projects = $this->repo->getProjectsList();
		$customers = $this->repo->getCustomersList();
		$vendors = $this->repo->getVendorsList();
		return view('subscriptions.edit',compact('subscription','projects','customers','vendors'));
	}

	public function update(UpdateRequest $req, $subscriptionId)
	{
		$subscription = $this->repo->update($req->except(['_method','_token']), $subscriptionId);
		flash()->success(trans('subscription.updated'));
		return redirect()->route('subscriptions.edit', $subscriptionId);
	}

	public function delete($subscriptionId)
	{
	    $subscription = $this->repo->requireById($subscriptionId);
		return view('subscriptions.delete', compact('subscription'));
	}

	public function destroy(DeleteRequest $req, $subscriptionId)
	{
		if ($subscriptionId == $req->get('subscription_id'))
		{
			$this->repo->delete($subscriptionId);
	        flash()->success(trans('subscription.deleted'));
		}
		else
			flash()->error(trans('subscription.undeleted'));

		return redirect()->route('subscriptions.index');
	}

}
