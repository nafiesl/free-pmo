<?php

namespace App\Queries;

use Carbon\Carbon;
use App\Entities\Users\User;
use App\Entities\Projects\Job;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;

/**
 * Admin Dashboard Query.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class AdminDashboardQuery
{
    /**
     * Get total money earned on an year.
     *
     * @param string|int $year
     *
     * @return int Amount of earnings
     */
    public function totalEarnings($year)
    {
        $totalEarnings = 0;
        $payments = Payment::where('date', 'like', $year.'%')->get();
        foreach ($payments as $payment) {
            if ($payment->in_out == 1) {
                $totalEarnings += $payment->amount;
            } else {
                $totalEarnings -= $payment->amount;
            }
        }

        return $totalEarnings;
    }

    /**
     * Get number of projects that has been finished on a year.
     *
     * @param string|int $year
     *
     * @return int Number of finished projects
     */
    public function totalFinishedProjects($year)
    {
        return Project::where('status_id', 4)->where('start_date', 'like', $year.'%')->count();
    }

    /**
     * Get current outstanding customer payment amount.
     *
     * @param string|int $year Year of queried payment records
     *
     * @return int Amount of outstanding customer payment
     */
    public function currentOutstandingCustomerPayment($year)
    {
        // On Progress, Done, On Hold
        $projects = Project::whereIn('status_id', [2, 3, 6])
            ->where('start_date', 'like', $year.'%')
            ->with('payments')
            ->get();

        $filteredProjects = $projects->filter(function ($project) {
            return $project->cashInTotal() < $project->project_value;
        })->values();

        $oustandingPaymentTotal = 0;

        foreach ($filteredProjects as $project) {
            $oustandingPaymentTotal += $project->project_value - $project->cashInTotal();
        }

        return $oustandingPaymentTotal;
    }

    /**
     * Get list of customer subscriptions that expires on next 60 days.
     *
     * @return \Illuminate\Support\Collection Collection of filtered subscriptions
     */
    public function upcomingSubscriptionDueDatesList()
    {
        $subscriptions = Subscription::orderBy('due_date', 'asc')->get();

        $filteredSubscriptions = $subscriptions->filter(function ($subscription) {
            return $subscription->status_id == 1
            && Carbon::parse($subscription->due_date)->diffInDays(Carbon::now()) < 60;
        });

        return $filteredSubscriptions->load('customer');
    }

    /**
     * Get on progress project jobs list.
     *
     * @return int
     */
    public function onProgressJobs(User $user, array $eagerLoads = [])
    {
        $eagerLoads = array_merge(['tasks'], $eagerLoads);
        $jobQuery = Job::whereHas('project', function ($query) {
            return $query->whereIn('status_id', [2, 3]);
        })->with($eagerLoads);

        if ($user->hasRole('admin') == false) {
            $jobQuery->where('worker_id', $user->id);
        }

        $jobs = $jobQuery->get()
            ->where('progress', '<', 100)
            ->values();

        return $jobs;
    }

    /**
     * Get on progress project jobs count.
     *
     * @return int
     */
    public function onProgressJobCount(User $user)
    {
        return $this->onProgressJobs($user)->count();
    }
}
