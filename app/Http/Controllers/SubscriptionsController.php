<?php

namespace App\Http\Controllers;

use App\Entities\Subscriptions\Subscription;
use App\Entities\Subscriptions\SubscriptionsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest as FormRequest;
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

    public function store(FormRequest $subscriptionCreateRequest)
    {
        $subscriptionCreateRequest->approveFor(new Subscription);

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

        $pageTitle = trans('subscription.edit').' - '.$subscription->name.' - '.$subscription->customer->name;

        return view('subscriptions.edit', compact('subscription', 'projects', 'vendors', 'subscriptionTypes', 'pageTitle'));
    }

    public function update(FormRequest $subscriptionUpdateRequest, Subscription $subscription)
    {
        $subscriptionUpdateRequest->approveFor($subscription);

        flash()->success(trans('subscription.updated'));
        return redirect()->route('subscriptions.edit', $subscription->id);
    }

    public function destroy(FormRequest $subscriptionDeleteRequest, Subscription $subscription)
    {
        $subscriptionDeleteRequest->approveToDelete($subscription);

        flash()->success(trans('subscription.deleted'));
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
