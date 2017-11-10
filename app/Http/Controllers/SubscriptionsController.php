<?php

namespace App\Http\Controllers;

use App\Entities\Subscriptions\Subscription;
use App\Entities\Subscriptions\SubscriptionsRepository;
use App\Entities\Subscriptions\Type;
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
        $subscriptions = $this->repo->getSubscriptions(
            $request->get('q'),
            $request->get('vendor_id')
        );

        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $projects = $this->repo->getProjectsList();
        $vendors = $this->repo->getVendorsList();

        return view('subscriptions.create', compact('projects', 'vendors'));
    }

    public function store(FormRequest $subscriptionCreateRequest)
    {
        $subscriptionCreateRequest->approveFor(new Subscription);

        flash()->success(trans('subscription.created'));
        return redirect()->route('subscriptions.index');
    }

    public function show(Subscription $subscription)
    {
        $pageTitle = $this->getPageTitle('detail', $subscription);

        return view('subscriptions.show', compact('subscription', 'pageTitle'));
    }

    public function edit(Subscription $subscription)
    {
        $projects = $this->repo->getProjectsList();
        $vendors = $this->repo->getVendorsList();

        $pageTitle = $this->getPageTitle('edit', $subscription);

        return view('subscriptions.edit', compact('subscription', 'projects', 'vendors', 'pageTitle'));
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

    private function getSubscriptionTypes()
    {
        return Type::toArray();
    }

    private function getPageTitle($pageType, $subscription)
    {
        return trans('subscription.'.$pageType).' - '.$subscription->name.' - '.$subscription->customer->name;
    }

}
