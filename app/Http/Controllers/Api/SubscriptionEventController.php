<?php

namespace App\Http\Controllers\Api;

use App\Entities\Subscriptions\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionEventController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $subscriptionQuery = Subscription::query();
        $subscriptionQuery->where('status_id', 1); // Active
        if ($start && $end) {
            $subscriptionQuery->whereBetween('due_date', [$start, $end]);
        }
        $subscriptions = $subscriptionQuery->with('project')->get();

        $response = fractal()
            ->collection($subscriptions)
            ->transformWith(function ($subscription) {
                return [
                    'id' => $subscription->id,
                    'project' => $subscription->project->name,
                    'project_id' => $subscription->project_id,
                    'title' => substr($subscription->name, 0, 23),
                    'body' => $subscription->notes,
                    'start' => $subscription->due_date,
                    'end' => null,
                    'allDay' => 1,
                    'editable' => 0,
                    'color' => '#E28800',
                    'type_id' => 'subscriptions',
                ];
            })
            ->toArray();

        return response()->json($response['data'], 200);
    }
}
