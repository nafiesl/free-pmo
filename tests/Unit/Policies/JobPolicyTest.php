<?php

namespace Tests\Unit\Policies;

use App\Entities\Projects\Job;
use Tests\TestCase as TestCase;

class JobPolicyTest extends TestCase
{
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
    public function an_admin_can_update_job()
    {
        $admin = $this->createUser('admin');
        $job = factory(Job::class)->create();

        $this->assertTrue($admin->can('update', $job));
    }

    /** @test */
    public function a_worker_can_only_update_job_that_assigned_to_them()
    {
        $assignedWorker = $this->createUser('worker');
        $job = factory(Job::class)->create(['worker_id' => $assignedWorker->id]);

        $this->assertTrue($assignedWorker->can('update', $job));

        $otherWorker = $this->createUser('worker');

        $this->assertFalse($otherWorker->can('update', $job));
    }

    /** @test */
    public function an_admin_can_delete_job()
    {
        $admin = $this->createUser('admin');
        $job = factory(Job::class)->create();

        $this->assertTrue($admin->can('delete', $job));
    }

    /** @test */
    public function a_worker_cannot_delete_job()
    {
        $worker = $this->createUser('worker');
        $job = factory(Job::class)->create();

        $this->assertFalse($worker->can('delete', $job));
    }
}
