<?php

namespace Tests\Feature\Api\Projects;

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReorderJobListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_reorder_job_position()
    {
        $admin = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $job1 = factory(Job::class)->create(['project_id' => $project->id, 'position' => 1]);
        $job2 = factory(Job::class)->create(['project_id' => $project->id, 'position' => 2]);

        $this->postJson(route('projects.jobs-reorder', $project), [
            'postData' => $job2->id.','.$job1->id,
        ]);

        $this->seeInDatabase('jobs', [
            'id'       => $job1->id,
            'position' => 2,
        ]);

        $this->seeInDatabase('jobs', [
            'id'       => $job2->id,
            'position' => 1,
        ]);
    }
}
