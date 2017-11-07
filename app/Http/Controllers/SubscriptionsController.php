<?php

namespace App\Http\Controllers;

use App\Entities\Subscriptions\Subscription;
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
        $vendors = $this->repo->getVendorsList();

        $subscriptionTypes = $this->getSubscriptionTypes();

        return view('subscriptions.create', compact('projects', 'vendors', 'subscriptionTypes'));
    }

    public function store(CreateRequest $request)
    {
        $project = \App\Entities\Projects\Project::findOrFail($request->get('project_id'));

        $subscription = new Subscription;
        $subscription->project_id = $project->id;
        $subscription->vendor_id = $request->get('vendor_id');
        $subscription->customer_id = $project->customer_id;
        $subscription->name = $request->get('name');
        $subscription->price = $request->get('price');
        $subscription->start_date = $request->get('start_date');
        $subscription->due_date = $request->get('due_date');
        $subscription->type_id = $request->get('type_id');
        $subscription->notes = $request->get('notes');
        $subscription->save();

        flash()->success(trans('subscription.created'));
        return redirect()->route('subscriptions.index');
    }

    public function show(Subscription $subscription)
    {
        return view('subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $projects = $this->repo->getProjectsList();
        $vendors = $this->repo->getVendorsList();
        $subscriptionTypes = $this->getSubscriptionTypes();

        return view('subscriptions.edit', compact('subscription', 'projects', 'vendors', 'subscriptionTypes'));
    }

    public function update(UpdateRequest $request, Subscription $subscription)
    {
        $project = \App\Entities\Projects\Project::findOrFail($request->get('project_id'));

        $subscriptionData = $request->except(['_method', '_token']);
        $subscriptionData['customer_id'] = $project->customer_id;

        $subscription->update($subscriptionData);

        flash()->success(trans('subscription.updated'));
        return redirect()->route('subscriptions.edit', $subscription->id);
    }

    public function delete(Subscription $subscription)
    {
        return view('subscriptions.delete', compact('subscription'));
    }

    public function destroy(DeleteRequest $request, Subscription $subscription)
    {
        if ($subscription->id == $request->get('subscription_id')) {
            $subscription->delete();
            flash()->success(trans('subscription.deleted'));
        } else {
            flash()->error(trans('subscription.undeleted'));
        }

        return redirect()->route('subscriptions.index');
    }

    public function getSubscriptionTypes()
    {
        return [
            1 => trans('subscription.types.domain'),
            2 => trans('subscription.types.hosting'),
        ];
    }

}
