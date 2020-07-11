<?php

namespace Tests\Unit\Queries;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Subscriptions\Subscription;
use App\Queries\AdminDashboardQuery;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardQueryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function retrieve_total_earnings_on_the_year()
    {
        factory(Payment::class)->create(['in_out' => 1, 'amount' => 500, 'date' => '2015-01-04']);
        factory(Payment::class, 2)->create(['in_out' => 1, 'amount' => 1000, 'date' => '2015-03-04']);
        factory(Payment::class, 2)->create(['in_out' => 0, 'amount' => 200, 'date' => '2015-09-04']);
        factory(Payment::class)->create(['in_out' => 1, 'amount' => 500, 'date' => '2016-01-04']);

        $this->assertEquals(2100, (new AdminDashboardQuery())->totalEarnings('2015'));
        $this->assertEquals(500, (new AdminDashboardQuery())->totalEarnings('2016'));
    }

    /** @test */
    public function retrieve_total_finished_projects_on_the_year()
    {
        factory(Project::class)->create(['status_id' => 4, 'start_date' => '2015-01-04']);
        factory(Project::class, 2)->create(['status_id' => 4, 'start_date' => '2015-03-04']);
        factory(Project::class, 2)->create(['status_id' => 5, 'start_date' => '2015-09-04']);
        factory(Project::class)->create(['status_id' => 4, 'start_date' => '2016-01-04']);

        $this->assertEquals(3, (new AdminDashboardQuery())->totalFinishedProjects('2015'));
        $this->assertEquals(1, (new AdminDashboardQuery())->totalFinishedProjects('2016'));
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

        $this->assertEquals(2000, (new AdminDashboardQuery())->currentOutstandingCustomerPayment('2015'));
        $this->assertEquals(1000, (new AdminDashboardQuery())->currentOutstandingCustomerPayment('2016'));
    }

    /** @test */
    public function retrieve_upcoming_customer_subscription_due_dates_list()
    {
        $dueDate = Carbon::now()->addMonth()->format('Y-m-d');

        factory(Subscription::class)->create(['due_date' => $dueDate]);
        factory(Subscription::class)->create(['due_date' => $dueDate]);
        factory(Subscription::class)->create(['due_date' => $dueDate, 'status_id' => 0]);
        factory(Subscription::class)->create(['due_date' => Carbon::now()->addMonths(3)->format('Y-m-d')]);

        $this->assertCount(2, (new AdminDashboardQuery())->upcomingSubscriptionDueDatesList());
    }

    /** @test */
    public function retrieve_job_on_progress_list()
    {
        $worker = $this->createUser('worker');
        $project1 = factory(Project::class)->create(['status_id' => 2]);
        $project1job1 = factory(Job::class)->create(['project_id' => $project1->id, 'worker_id' => $worker->id]);
        $project1job1Task1 = factory(Task::class)->create(['job_id' => $project1job1->id, 'progress' => 50]);
        $project1job1Task2 = factory(Task::class)->create(['job_id' => $project1job1->id, 'progress' => 100]);

        $project1job2 = factory(Job::class)->create(['project_id' => $project1->id, 'worker_id' => $worker->id]);
        $project1job2Task1 = factory(Task::class)->create(['job_id' => $project1job2->id, 'progress' => 100]);
        $project1job2Task2 = factory(Task::class)->create(['job_id' => $project1job2->id, 'progress' => 100]);

        $project2 = factory(Project::class)->create(['status_id' => 2]);
        $project2job1 = factory(Job::class)->create(['project_id' => $project2->id, 'worker_id' => $worker->id]);
        $project2job1Task1 = factory(Task::class)->create(['job_id' => $project2job1->id, 'progress' => 50]);
        $project2job1Task2 = factory(Task::class)->create(['job_id' => $project2job1->id, 'progress' => 100]);

        $project2job2 = factory(Job::class)->create(['project_id' => $project2->id, 'worker_id' => $worker->id]);
        $project2job2Task1 = factory(Task::class)->create(['job_id' => $project2job2->id, 'progress' => 50]);
        $project2job2Task2 = factory(Task::class)->create(['job_id' => $project2job2->id, 'progress' => 100]);

        $this->assertCount(2, Project::all());
        $this->assertCount(4, Job::all());
        $this->assertCount(8, Task::all());
        $this->assertCount(3, (new AdminDashboardQuery())->onProgressJobs($worker));
    }

    /** @test */
    public function retrieve_job_on_progress_count()
    {
        $worker = $this->createUser('worker');
        $project1 = factory(Project::class)->create(['status_id' => 2]);
        $project1job1 = factory(Job::class)->create(['project_id' => $project1->id, 'worker_id' => $worker->id]);
        $project1job1Task1 = factory(Task::class)->create(['job_id' => $project1job1->id, 'progress' => 50]);
        $project1job1Task2 = factory(Task::class)->create(['job_id' => $project1job1->id, 'progress' => 100]);

        $project1job2 = factory(Job::class)->create(['project_id' => $project1->id, 'worker_id' => $worker->id]);
        $project1job2Task1 = factory(Task::class)->create(['job_id' => $project1job2->id, 'progress' => 100]);
        $project1job2Task2 = factory(Task::class)->create(['job_id' => $project1job2->id, 'progress' => 100]);

        $project2 = factory(Project::class)->create(['status_id' => 2]);
        $project2job1 = factory(Job::class)->create(['project_id' => $project2->id, 'worker_id' => $worker->id]);
        $project2job1Task1 = factory(Task::class)->create(['job_id' => $project2job1->id, 'progress' => 50]);
        $project2job1Task2 = factory(Task::class)->create(['job_id' => $project2job1->id, 'progress' => 100]);

        $project2job2 = factory(Job::class)->create(['project_id' => $project2->id, 'worker_id' => $worker->id]);
        $project2job2Task1 = factory(Task::class)->create(['job_id' => $project2job2->id, 'progress' => 50]);
        $project2job2Task2 = factory(Task::class)->create(['job_id' => $project2job2->id, 'progress' => 100]);

        $this->assertCount(2, Project::all());
        $this->assertCount(4, Job::all());
        $this->assertCount(8, Task::all());
        $this->assertEquals(3, (new AdminDashboardQuery())->onProgressJobCount($worker));
    }
}
