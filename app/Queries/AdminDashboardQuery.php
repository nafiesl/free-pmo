<?php

namespace App\Queries;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use Carbon\Carbon;

/**
 * AdminDashboardQuery
 */
class AdminDashboardQuery
{
    /**
     * Get total money earned on an year
     *
     * @param  string|integer $year
     * @return integer       Amount of earnings
     */
    public function totalEarnings($year)
    {
        $totalEarnings = 0;
        $payments      = Payment::where('date', 'like', $year.'%')->get();
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
     * Get number of projects that has been finished on a year
     *
     * @param  string|integer $year
     * @return integer       Number of finished projects
     */
    public function totalFinishedProjects($year)
    {
        return Project::where('status_id', 4)->where('start_date', 'like', $year.'%')->count();
    }

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

    public function upcomingSubscriptionDueDatesList()
    {
        $subscriptions = Subscription::get();

        $filteredSubscriptions = $subscriptions->filter(function ($subscription) {
            return $subscription->status_id == 1
            && Carbon::parse($subscription->due_date)->diffInDays(Carbon::now()) < 60;
        });

        return $filteredSubscriptions;
    }
}
