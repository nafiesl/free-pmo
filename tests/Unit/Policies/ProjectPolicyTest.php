<?php

namespace Tests\Unit\Policies;

use App\Entities\Projects\Project;
use Tests\TestCase as TestCase;

class ProjectPolicyTest extends TestCase
{
    /** @test */
    public function an_admin_can_create_project()
    {
        $admin = $this->createUser('admin');

        $this->assertTrue($admin->can('create', new Project()));
    }

    /** @test */
    public function a_worker_cannot_create_project()
    {
        $worker = $this->createUser('worker');

        $this->assertFalse($worker->can('create', new Project()));
    }

    /** @test */
    public function an_admin_can_view_project()
    {
        $admin = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('view', $project));
    }

    /** @test */
    public function an_admin_can_update_project()
    {
        $admin = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('update', $project));
    }

    /** @test */
    public function a_worker_cannot_update_project()
    {
        $worker = $this->createUser('worker');
        $project = factory(Project::class)->create();

        $this->assertFalse($worker->can('update', $project));
    }

    /** @test */
    public function an_admin_can_delete_project()
    {
        $admin = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('delete', $project));
    }

    /** @test */
    public function a_worker_cannot_delete_project()
    {
        $worker = $this->createUser('worker');
        $project = factory(Project::class)->create();

        $this->assertFalse($worker->can('delete', $project));
    }
}
