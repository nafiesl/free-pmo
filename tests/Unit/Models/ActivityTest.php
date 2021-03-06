<?php

namespace Tests\Unit\Models;

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_project_creation_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();

        $this->seeInDatabase('user_activities', [
            'type'        => 'project_created',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $project->id,
            'object_type' => 'projects',
            'data'        => null,
        ]);
    }

    /** @test */
    public function it_records_project_data_update_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['name' => 'New Project']);

        $project->name = 'Updated project';
        $project->save();

        $this->seeInDatabase('user_activities', [
            'type'        => 'project_updated',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $project->id,
            'object_type' => 'projects',
            'data'        => json_encode([
                'before' => ['name' => 'New Project'],
                'after'  => ['name' => 'Updated project'],
                'notes'  => null,
            ]),
        ]);
    }

    /** @test */
    public function it_records_job_creation_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create(['project_id' => $project->id]);

        $this->seeInDatabase('user_activities', [
            'type'        => 'job_created',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $job->id,
            'object_type' => 'jobs',
            'data'        => null,
        ]);
    }

    /** @test */
    public function it_records_job_data_update_activities()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job = factory(Job::class)->create([
            'name'       => 'New Job',
            'project_id' => $project->id,
        ]);

        $job->name = 'Updated job';
        $job->save();

        $this->seeInDatabase('user_activities', [
            'type'        => 'job_updated',
            'parent_id'   => null,
            'user_id'     => $admin->id,
            'object_id'   => $job->id,
            'object_type' => 'jobs',
            'data'        => json_encode([
                'before' => ['name' => 'New Job'],
                'after'  => ['name' => 'Updated job'],
                'notes'  => null,
            ]),
        ]);
    }
}
