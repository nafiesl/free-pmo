<?php

namespace App\Http\Controllers;

use App\Entities\Subscriptions\Subscription;
use App\Entities\Subscriptions\Type;
use App\Http\Requests\SubscriptionRequest as FormRequest;
use Illuminate\Http\Request;

/**
 * Subscriptions Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class SubscriptionsController extends Controller
{
    /**
     * Show subscription list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $subscriptions = $this->getSubscriptionListing(
            $request->get('q'),
            $request->get('vendor_id')
        );

        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show subscription create page.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $projects = $this->getProjectsList();
        $vendors = $this->getVendorsList();

        return view('subscriptions.create', compact('projects', 'vendors'));
    }

    /**
     * Store new subscription to database.
     *
     * @param  \App\Http\Requests\SubscriptionRequest  $subscriptionCreateRequest
     * @return \Illuminate\Routing\Redirector
     */
    public function store(FormRequest $subscriptionCreateRequest)
    {
        $subscriptionCreateRequest->approveToCreate(new Subscription());
        flash(__('subscription.created'), 'success');

        return redirect()->route('subscriptions.index');
    }

    /**
     * Show a subscription detail.
     *
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return \Illuminate\View\View
     */
    public function show(Subscription $subscription)
    {
        $pageTitle = $this->getPageTitle('detail', $subscription);

        return view('subscriptions.show', compact('subscription', 'pageTitle'));
    }

    /**
     * Show a subscription edit form.
     *
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return \Illuminate\View\View
     */
    public function edit(Subscription $subscription)
    {
        $projects = $this->getProjectsList();
        $vendors = $this->getVendorsList();

        $pageTitle = $this->getPageTitle('edit', $subscription);

        return view('subscriptions.edit', compact('subscription', 'projects', 'vendors', 'pageTitle'));
    }

    /**
     * Update a subscription on database.
     *
     * @param  \App\Http\Requests\SubscriptionRequest  $subscriptionUpdateRequest
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return \Illuminate\Routing\Redirector
     */
    public function update(FormRequest $subscriptionUpdateRequest, Subscription $subscription)
    {
        $subscriptionUpdateRequest->approveToUpdate($subscription);
        flash(__('subscription.updated'), 'success');

        return redirect()->route('subscriptions.edit', $subscription->id);
    }

    /**
     * Delete a subscription from database.
     *
     * @param  \App\Http\Requests\SubscriptionRequest  $subscriptionDeleteRequest
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(FormRequest $subscriptionDeleteRequest, Subscription $subscription)
    {
        $subscriptionDeleteRequest->approveToDelete($subscription);
        flash(__('subscription.deleted'), 'success');

        return redirect()->route('subscriptions.index');
    }

    /**
     * Get subscription type list.
     *
     * @return array
     */
    private function getSubscriptionTypes()
    {
        return Type::toArray();
    }

    /**
     * Get page title based on subscription page type.
     *
     * @param  string  $pageType
     * @param  \App\Entities\Subscriptions\Subscription  $subscription
     * @return string
     */
    private function getPageTitle($pageType, $subscription)
    {
        return __('subscription.'.$pageType).' - '.$subscription->name.' - '.$subscription->customer->name;
    }

    /**
     * Get subscrioption list.
     *
     * @param  string  $searchQuery
     * @param  int  $vendorId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function getSubscriptionListing($searchQuery, $vendorId)
    {
        $subscriptionQuery = Subscription::orderBy('status_id', 'desc')
            ->orderBy('due_date')
            ->with('customer', 'vendor');

        if ($searchQuery) {
            $subscriptionQuery->where('name', 'like', '%'.$searchQuery.'%');
        }
        if ($vendorId) {
            $subscriptionQuery->where('vendor_id', $vendorId);
        }

        return $subscriptionQuery->paginate(25);
    }
}
