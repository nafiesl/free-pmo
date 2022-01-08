<?php

namespace Tests\Unit\Models;

use App\Entities\Invoices\Invoice;
use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Projects\Comment;
use App\Entities\Projects\File;
use App\Entities\Projects\Issue;
use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use App\Entities\Projects\Task;
use App\Entities\Subscriptions\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_name_link_method()
    {
        $project = factory(Project::class)->create();
        $this->assertEquals(
            link_to_route('projects.show', $project->name, [$project->id], [
                'title' => __(
                    'app.show_detail_title',
                    ['name' => $project->name, 'type' => __('project.project')]
                ),
            ]), $project->nameLink()
        );
    }

    /** @test */
    public function a_project_has_many_jobs()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);
        $this->assertInstanceOf(Collection::class, $project->jobs);
        $this->assertInstanceOf(Job::class, $project->jobs->first());
    }

    /** @test */
    public function project_deletion_also_deletes_related_jobs()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);

        $project->delete();

        $this->dontSeeInDatabase('jobs', [
            'project_id' => $project->id,
        ]);
    }

    /** @test */
    public function a_project_has_many_main_jobs()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1]);
        $this->assertInstanceOf(Collection::class, $project->mainJobs);
        $this->assertInstanceOf(Job::class, $project->mainJobs->first());
    }

    /** @test */
    public function a_project_has_many_additional_jobs()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 2]);
        $this->assertInstanceOf(Collection::class, $project->additionalJobs);
        $this->assertInstanceOf(Job::class, $project->additionalJobs->first());
    }

    /** @test */
    public function a_project_has_job_tasks()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 2]);
        $tasks = factory(Task::class, 2)->create(['job_id' => $job->id]);
        $this->assertInstanceOf(Collection::class, $project->tasks);
        $this->assertInstanceOf(Task::class, $project->tasks->first());
    }

    /** @test */
    public function project_deletion_also_deletes_related_job_tasks()
    {
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 2]);
        $tasks = factory(Task::class, 2)->create(['job_id' => $job->id]);

        $project->delete();

        $this->dontSeeInDatabase('tasks', [
            'job_id' => $job->id,
        ]);
    }

    /** @test */
    public function a_project_has_many_payments_relation()
    {
        $project = factory(Project::class)->create();
        $payment = factory(Payment::class)->create(['project_id' => $project->id]);

        $this->assertInstanceOf(Collection::class, $project->payments);
        $this->assertInstanceOf(Payment::class, $project->payments->first());
    }

    /** @test */
    public function project_deletion_also_deletes_related_payments()
    {
        $project = factory(Project::class)->create();
        $payment = factory(Payment::class)->create(['project_id' => $project->id]);

        $project->delete();

        $this->dontSeeInDatabase('payments', [
            'project_id' => $project->id,
        ]);
    }

    /** @test */
    public function a_project_has_many_subscriptions()
    {
        $project = factory(Project::class)->create();
        $subscription = factory(Subscription::class)->create(['project_id' => $project->id]);
        $this->assertInstanceOf(Collection::class, $project->subscriptions);
        $this->assertInstanceOf(Subscription::class, $project->subscriptions->first());
    }

    /** @test */
    public function project_deletion_also_deletes_related_subscriptions()
    {
        $project = factory(Project::class)->create();
        $subscription = factory(Subscription::class)->create(['project_id' => $project->id]);

        $project->delete();

        $this->dontSeeInDatabase('subscriptions', [
            'project_id' => $project->id,
        ]);
    }

    /** @test */
    public function a_project_belongs_to_a_customer()
    {
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Customer::class, $project->customer);
        $this->assertEquals($project->customer_id, $customer->id);
    }

    /** @test */
    public function a_project_has_cash_in_total_method()
    {
        $project = factory(Project::class)->create();
        $payments = factory(Payment::class, 2)->create(['project_id' => $project->id, 'in_out' => 1, 'amount' => 20000]);
        $this->assertEquals(40000, $project->cashInTotal());
    }

    /** @test */
    public function a_project_has_cash_out_total_method()
    {
        $project = factory(Project::class)->create();
        $payments = factory(Payment::class, 2)->create(['project_id' => $project->id, 'in_out' => 0, 'amount' => 10000]);
        factory(Payment::class)->create(['project_id' => $project->id, 'in_out' => 1, 'amount' => 10000]);
        $this->assertEquals(20000, $project->cashOutTotal());
    }

    /** @test */
    public function a_project_has_job_overall_progress_method()
    {
        $project = factory(Project::class)->create();

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 2000]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 20]);

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 3000]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 30]);

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 1500]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 1500]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);

        $this->assertEquals(53.75, $project->getJobOveralProgress());
    }

    /** @test */
    public function project_job_overall_progress_returns_average_job_progress_if_job_prices_is_zero()
    {
        $project = factory(Project::class)->create();

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 20]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 30]);

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);

        $this->assertEquals(75, $project->getJobOveralProgress());
    }

    /** @test */
    public function a_project_returns_0_on_job_overall_progress_method_if_all_job_is_free()
    {
        $project = factory(Project::class)->create();

        factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);
        factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 0]);

        $this->assertEquals(0, $project->getJobOveralProgress());
    }

    /** @test */
    public function a_project_has_many_files()
    {
        $project = factory(Project::class)->create();

        $this->assertInstanceOf(Collection::class, $project->files);
    }

    /** @test */
    public function project_deletion_also_deletes_related_files()
    {
        $project = factory(Project::class)->create();
        $file = File::create([
            'fileable_id' => $project->id,
            'fileable_type' => 'projects',
            'filename' => 'filename.jpg',
            'title' => 'filename.jpg',
        ]);

        $project->delete();

        $this->dontSeeInDatabase('files', [
            'fileable_id' => $project->id,
            'fileable_type' => 'projects',
        ]);
    }

    /** @test */
    public function a_project_has_collectible_earnings_method()
    {
        // Collectible earnings is total of (price * avg task progress of each job)
        $project = factory(Project::class)->create();

        $collectibeEarnings = 0;

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 2000]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 20]);
        $collectibeEarnings += (2000 * (20 / 100)); // job price * avg task progress

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 3000]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 30]);
        $collectibeEarnings += (3000 * (30 / 100));

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 1500]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);
        $collectibeEarnings += (1500 * (100 / 100));

        $job = factory(Job::class)->create(['project_id' => $project->id, 'type_id' => 1, 'price' => 1500]);
        factory(Task::class)->create(['job_id' => $job->id, 'progress' => 100]);
        $collectibeEarnings += (1500 * (100 / 100));

        // $collectibeEarnings = 400 + 900 + 1500 + 1500;

        $this->assertEquals($collectibeEarnings, $project->getCollectibeEarnings());
    }

    /** @test */
    public function a_project_has_many_comments_relation()
    {
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'projects',
            'commentable_id' => $project->id,
        ]);

        $this->assertInstanceOf(Collection::class, $project->comments);
        $this->assertInstanceOf(Comment::class, $project->comments->first());
    }

    /** @test */
    public function project_deletion_also_deletes_related_comments()
    {
        $project = factory(Project::class)->create();
        $comment = factory(Comment::class)->create([
            'commentable_type' => 'projects',
            'commentable_id' => $project->id,
        ]);

        $project->delete();

        $this->dontSeeInDatabase('comments', [
            'commentable_type' => 'projects',
            'commentable_id' => $project->id,
        ]);
    }

    /** @test */
    public function project_has_work_duration_attribute()
    {
        $project = factory(Project::class)->create([
            'start_date' => '2016-06-10',
            'end_date' => '2016-07-21',
        ]);

        $this->assertEquals('1 Month(s) 11 Day(s)', $project->work_duration);
    }

    /** @test */
    public function project_work_duration_attribute_returns_proper_multi_years_work_duration()
    {
        $project = factory(Project::class)->create([
            'start_date' => '2015-04-10',
            'end_date' => '2017-07-21',
        ]);

        $this->assertEquals('2 Year(s) 3 Month(s)', $project->work_duration);
    }

    /** @test */
    public function a_project_has_many_invoices_relation()
    {
        $project = factory(Project::class)->create();
        $invoice = factory(Invoice::class)->create(['project_id' => $project->id]);

        $this->assertInstanceOf(Collection::class, $project->invoices);
        $this->assertInstanceOf(Invoice::class, $project->invoices->first());
    }

    /** @test */
    public function project_deletion_also_deletes_related_invoices()
    {
        $project = factory(Project::class)->create();
        $invoice = factory(Invoice::class)->create(['project_id' => $project->id]);

        $project->delete();

        $this->dontSeeInDatabase('invoices', [
            'project_id' => $project->id,
        ]);
    }

    /** @test */
    public function a_project_has_many_issues_relation()
    {
        $project = factory(Project::class)->create();
        $issue = factory(Issue::class)->create(['project_id' => $project->id]);

        $this->assertInstanceOf(Collection::class, $project->issues);
        $this->assertInstanceOf(Issue::class, $project->issues->first());
    }
}
