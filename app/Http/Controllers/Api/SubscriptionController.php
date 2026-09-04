<?php

namespace App\Http\Controllers\Api;

use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptionQuery = Subscription::orderBy('status_id', 'desc')
            ->orderBy('due_date')
            ->with('customer', 'vendor');

        if ($request->q) {
            $subscriptionQuery->where('name', 'like', '%'.$request->q.'%');
        }
        if ($request->vendor_id) {
            $subscriptionQuery->where('vendor_id', $request->vendor_id);
        }

        return response()->json($subscriptionQuery->paginate(25), 200);
    }

    public function show(Subscription $subscription)
    {
        $this->authorize('view', $subscription);

        return $subscription->load('project', 'customer', 'vendor');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Subscription);

        $subscriptionData = $request->validate([
            'name' => 'required|max:60',
            'price' => 'required|numeric',
            'start_date' => 'required|date|date_format:Y-m-d',
            'due_date' => 'required|date|date_format:Y-m-d',
            'project_id' => 'required|numeric|exists:projects,id',
            'vendor_id' => 'required|numeric|exists:vendors,id',
            'type_id' => 'required|numeric',
            'notes' => 'nullable|max:255',
        ]);

        $project = Project::findOrFail($subscriptionData['project_id']);
        $subscriptionData['customer_id'] = $project->customer_id;

        $subscription = Subscription::create($subscriptionData);

        return response()->json(['message' => __('subscription.created'), 'id' => $subscription->id], 201);
    }

    public function update(Request $request, Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        $subscriptionData = $request->validate([
            'name' => 'sometimes|max:60',
            'price' => 'sometimes|numeric',
            'start_date' => 'sometimes|date|date_format:Y-m-d',
            'due_date' => 'sometimes|date|date_format:Y-m-d',
            'project_id' => 'sometimes|numeric|exists:projects,id',
            'vendor_id' => 'sometimes|numeric|exists:vendors,id',
            'type_id' => 'sometimes|numeric',
            'status_id' => 'sometimes|numeric',
            'notes' => 'sometimes|max:255',
        ]);

        if (isset($subscriptionData['project_id'])) {
            $project = Project::findOrFail($subscriptionData['project_id']);
            $subscriptionData['customer_id'] = $project->customer_id;
        }

        $subscription->update($subscriptionData);

        return response()->json(['message' => __('subscription.updated')], 200);
    }

    public function destroy(Subscription $subscription)
    {
        $this->authorize('delete', $subscription);

        $subscription->delete();

        return response()->json(['message' => __('subscription.deleted')], 200);
    }
}
