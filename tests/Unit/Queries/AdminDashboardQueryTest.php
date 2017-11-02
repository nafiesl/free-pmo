<?php

namespace Tests\Unit\Queries;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Subscriptions\Subscription;
use App\Queries\AdminDashboardQuery;
use Carbon\Carbon;
use Tests\TestCase;

class AdminDashboardQueryTest extends TestCase
{
    /** @test */
    public function retrieve_total_earnings_on_the_year()
    {
        factory(Payment::class)->create(['in_out' => 1, 'amount' => 500, 'date' => '2015-01-04']);
        factory(Payment::class, 2)->create(['in_out' => 1, 'amount' => 1000, 'date' => '2015-03-04']);
        factory(Payment::class, 2)->create(['in_out' => 0, 'amount' => 200, 'date' => '2015-09-04']);
        factory(Payment::class)->create(['in_out' => 1, 'amount' => 500, 'date' => '2016-01-04']);

        $this->assertEquals(2100, (new AdminDashboardQuery)->totalEarnings('2015'));
        $this->assertEquals(500, (new AdminDashboardQuery)->totalEarnings('2016'));
    }

    /** @test */
    public function retrieve_total_finished_projects_on_the_year()
    {
        factory(Project::class)->create(['status_id' => 4, 'start_date' => '2015-01-04']);
        factory(Project::class, 2)->create(['status_id' => 4, 'start_date' => '2015-03-04']);
        factory(Project::class, 2)->create(['status_id' => 5, 'start_date' => '2015-09-04']);
        factory(Project::class)->create(['status_id' => 4, 'start_date' => '2016-01-04']);

        $this->assertEquals(3, (new AdminDashboardQuery)->totalFinishedProjects('2015'));
        $this->assertEquals(1, (new AdminDashboardQuery)->totalFinishedProjects('2016'));
    }

    /** @test */
    public function retrieve_current_outstanding_customer_payment()
    {
        $project = factory(Project::class)->create(['project_value' => 2000, 'status_id' => 2, 'start_date' => '2015-01-04']);
        factory(Payment::class)->create(['project_id' => $project->id, 'amount' => 1000]);

        $project = factory(Project::class)->create(['project_value' => 2000, 'status_id' => 3, 'start_date' => '2015-03-04']);
        factory(Payment::class)->create(['project_id' => $project->id, 'amount' => 1000]);

        $project = factory(Project::class)->create(['project_value' => 2000, 'status_id' => 1, 'start_date' => '2015-09-04']);
        factory(Payment::class)->create(['project_id' => $project->id, 'amount' => 1000]);

        $project = factory(Project::class)->create(['project_value' => 2000, 'status_id' => 3, 'start_date' => '2016-01-04']);
        factory(Payment::class)->create(['project_id' => $project->id, 'amount' => 1000]);

        $this->assertEquals(2000, (new AdminDashboardQuery)->currentOutstandingCustomerPayment('2015'));
        $this->assertEquals(1000, (new AdminDashboardQuery)->currentOutstandingCustomerPayment('2016'));
    }

    /** @test */
    public function retrieve_upcoming_customer_subscription_due_dates_list()
    {
        $dueDate = Carbon::now()->addMonth()->format('Y-m-d');

        factory(Subscription::class)->create(['due_date' => $dueDate]);
        factory(Subscription::class)->create(['due_date' => $dueDate]);
        factory(Subscription::class)->create(['due_date' => $dueDate, 'status_id' => 0]);
        factory(Subscription::class)->create(['due_date' => Carbon::now()->addMonths(3)->format('Y-m-d')]);

        $this->assertCount(2, (new AdminDashboardQuery)->upcomingSubscriptionDueDatesList());
    }
}
