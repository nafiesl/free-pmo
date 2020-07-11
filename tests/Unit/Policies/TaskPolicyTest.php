<?php

namespace Tests\Unit\Policies;

use App\Entities\Projects\Job;
use App\Entities\Projects\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_admin_can_create_task_on_a_job()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $this->assertTrue($admin->can('create', new Task()));
        $this->assertFalse($worker->can('create', new Task()));
    }

    /** @test */
    public function an_admin_can_update_task()
    {
        $admin = $this->createUser('admin');
        $task = factory(Task::class)->create();

        $this->assertTrue($admin->can('update', $task));
    }

    /** @test */
    public function a_worker_can_only_update_task_that_belongs_to_a_job_that_has_assign_to_them()
    {
        $worker = $this->createUser('worker');
        $job = factory(Job::class)->create(['worker_id' => $worker->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $this->assertTrue($worker->can('update', $worker));
    }

    /** @test */
    public function an_admin_can_delete_any_task()
    {
        $admin = $this->createUser('admin');
        $task = factory(Task::class)->create();

        $this->assertTrue($admin->can('delete', $task));
    }

    /** @test */
    public function a_worker_cannot_delete_their_tasks()
    {
        $worker = $this->createUser('worker');
        $task = factory(Task::class)->create();

        $this->assertFalse($worker->can('delete', $task));

        $job = factory(Job::class)->create(['worker_id' => $worker->id]);
        $task = factory(Task::class)->create(['job_id' => $job->id]);

        $this->assertFalse($worker->can('delete', $task));
    }
}
