<?php

namespace Tests\Unit\Policies;

use App\Entities\Projects\Job;
use Tests\TestCase as TestCase;
use App\Entities\Projects\Project;

class ProjectPolicyTest extends TestCase
{
    /** @test */
    public function only_admin_can_create_project()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $this->assertTrue($admin->can('create', new Project()));
        $this->assertFalse($worker->can('create', new Project()));
    }

    /** @test */
    public function an_admin_can_view_all_project_detail()
    {
        $admin = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('view', $project));
    }

    /** @test */
    public function a_worker_can_only_view_the_project_in_which_they_are_involved()
    {
        $worker = $this->createUser('worker');
        $project = factory(Project::class)->create();

        // Worker cannot view the project
        $this->assertFalse($worker->can('view', $project));

        // Assign a job to worker on the project
        factory(Job::class)->create([
            'project_id' => $project->id,
            'worker_id'  => $worker->id,
        ]);

        // Worker can view the project after assignment
        $this->assertTrue($worker->fresh()->can('view', $project));
    }

    /** @test */
    public function only_admin_can_update_project()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $this->assertTrue($admin->can('update', new Project()));
        $this->assertFalse($worker->can('update', new Project()));
    }

    /** @test */
    public function only_admin_can_delete_project()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('delete', $project));
        $this->assertFalse($worker->can('delete', $project));
    }

    /** @test */
    public function admin_and_worker_view_project_job_list()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create([
            'project_id' => $project->id,
            'worker_id'  => $worker->id,
        ]);

        $this->assertTrue($admin->can('view-jobs', $project));
        $this->assertTrue($worker->can('view-jobs', $project));
    }

    /** @test */
    public function only_admin_view_project_payment_list()
    {
        $admin = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('view-payments', $project));
    }

    /** @test */
    public function only_admin_view_project_subscription_list()
    {
        $admin = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('view-subscriptions', $project));
    }

    /** @test */
    public function only_admin_view_project_invoice_list()
    {
        $admin = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->assertTrue($admin->can('view-invoices', $project));
    }

    /** @test */
    public function admin_and_worker_view_project_file_list()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create([
            'project_id' => $project->id,
            'worker_id'  => $worker->id,
        ]);

        $this->assertTrue($admin->can('view-files', $project));
        $this->assertTrue($worker->can('view-files', $project));
    }

    /** @test */
    public function only_admin_can_see_project_pricings()
    {
        $admin = $this->createUser('admin');
        $worker = $this->createUser('worker');

        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create([
            'project_id' => $project->id,
            'worker_id'  => $worker->id,
        ]);

        $this->assertTrue($admin->can('see-pricings', $project));
        $this->assertFalse($worker->can('see-pricings', $project));
    }
}
