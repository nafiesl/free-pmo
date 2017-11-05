<?php

namespace App\Http\Controllers;

use App\Entities\Subscriptions\SubscriptionsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriptions\CreateRequest;
use App\Http\Requests\Subscriptions\DeleteRequest;
use App\Http\Requests\Subscriptions\UpdateRequest;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    private $repo;

    public function __construct(SubscriptionsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $subscriptions = $this->repo->getSubscriptions($request->get('q'), $request->get('vendor_id'));
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $projects = $this->repo->getProjectsList();
        $vendors  = $this->repo->getVendorsList();

        $subscriptionTypes = [
            1 => trans('subscription.types.domain'),
            2 => trans('subscription.types.hosting'),
        ];

        return view('subscriptions.create', compact('projects', 'vendors', 'subscriptionTypes'));
    }

    public function store(CreateRequest $request)
    {
        $subscription = $this->repo->create($request->except('_token'));
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
        $projects     = $this->repo->getProjectsList();
        $customers    = $this->repo->getCustomersList();
        $vendors      = $this->repo->getVendorsList();
        return view('subscriptions.edit', compact('subscription', 'projects', 'customers', 'vendors'));
    }

    public function update(UpdateRequest $request, $subscriptionId)
    {
        $subscription = $this->repo->update($request->except(['_method', '_token']), $subscriptionId);
        flash()->success(trans('subscription.updated'));
        return redirect()->route('subscriptions.edit', $subscriptionId);
    }

    public function delete($subscriptionId)
    {
        $subscription = $this->repo->requireById($subscriptionId);
        return view('subscriptions.delete', compact('subscription'));
    }

    public function destroy(DeleteRequest $request, $subscriptionId)
    {
        if ($subscriptionId == $request->get('subscription_id')) {
            $this->repo->delete($subscriptionId);
            flash()->success(trans('subscription.deleted'));
        } else {
            flash()->error(trans('subscription.undeleted'));
        }

        return redirect()->route('subscriptions.index');
    }

}
