<?php

namespace Tests\Unit\Policies;

use App\Entities\Projects\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_create_job_on_a_project()
    {
        $admin = $this->createUser('admin');

        $this->assertTrue($admin->can('create', new Job()));
    }

    /** @test */
    public function a_worker_cannot_create_job_on_a_project()
    {
        $worker = $this->createUser('worker');

        $this->assertFalse($worker->can('create', new Job()));
    }

    /** @test */
    public function an_admin_can_view_job_on_a_project()
    {
        $admin = $this->createUser('admin');
        $job = factory(Job::class)->create();

        $this->assertTrue($admin->can('view', $job));
    }

    /** @test */
    public function a_worker_only_can_view_jobs_that_has_been_assigned_to_them()
    {
        $worker = $this->createUser('worker');
        $job = factory(Job::class)->create();

        // Worker cannot view the job
        $this->assertFalse($worker->can('view', $job));

        // Assign the job to the worker
        $job->worker_id = $worker->id;
        $job->save();

        // Worker can view the job
        $this->assertTrue($worker->can('view', $job));
    }

    /** @test */
    public function only_admin_can_update_job()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $job = factory(Job::class)->create(['worker_id' => $worker->id]);

        $this->assertTrue($admin->can('update', $job));
        $this->assertFalse($worker->can('update', $job));
    }

    /** @test */
    public function only_admin_can_delete_job()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $job = factory(Job::class)->create(['worker_id' => $worker->id]);

        $this->assertTrue($admin->can('update', $job));
        $this->assertFalse($worker->can('update', $job));
    }

    /** @test */
    public function only_admin_can_see_job_pricings()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $job = factory(Job::class)->create(['worker_id' => $worker->id]);

        $this->assertTrue($admin->can('see-pricings', $job));
        $this->assertFalse($worker->can('see-pricings', $job));
    }

    /** @test */
    public function admin_and_worker_view_job_comment_list()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $job = factory(Job::class)->create([
            'worker_id' => $worker->id,
        ]);

        $this->assertTrue($admin->can('view-comments', $job));
        $this->assertTrue($worker->can('view-comments', $job));
    }

    /** @test */
    public function admin_and_job_workers_can_add_comment_to_job()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $job = factory(Job::class)->create([
            'worker_id' => $worker->id,
        ]);

        $this->assertTrue($admin->can('comment-on', $job));
        $this->assertTrue($worker->can('comment-on', $job));
    }
}
