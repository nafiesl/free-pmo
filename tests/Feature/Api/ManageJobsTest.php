<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Job;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageJobsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_list_jobs_by_project()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        factory(Job::class)->create(['project_id' => $project->id, 'name' => 'Feature 7']);

        $this->getJson(route('api.jobs.index', ['project_id' => $project->id]), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function admin_can_create_job()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();
        $worker = $this->createUser('worker');

        $this->postJson(route('api.jobs.store'), [
            'project_id' => $project->id,
            'name' => 'API BAM: Submit Manifest & Resi',
            'worker_id' => $worker->id,
            'price' => 1100000,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('job.created')]);
        $this->seeInDatabase('jobs', ['name' => 'API BAM: Submit Manifest & Resi']);
    }

    /** @test */
    public function admin_cannot_create_job_without_worker()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->postJson(route('api.jobs.store'), [
            'project_id' => $project->id,
            'name' => 'API BAM: Submit Manifest & Resi',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(422);
        $this->dontSeeInDatabase('jobs', ['name' => 'API BAM: Submit Manifest & Resi']);
    }

    /** @test */
    public function admin_can_show_job()
    {
        $user = $this->createUser('admin');
        $job = factory(Job::class)->create();

        $this->getJson(route('api.jobs.show', $job), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['id' => $job->id]);
    }

    /** @test */
    public function admin_can_update_job()
    {
        $user = $this->createUser('admin');
        $job = factory(Job::class)->create(['name' => 'Old Name']);

        $this->patchJson(route('api.jobs.update', $job), [
            'name' => 'Updated Job Name',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('job.updated')]);
        $this->seeInDatabase('jobs', ['id' => $job->id, 'name' => 'Updated Job Name']);
    }

    /** @test */
    public function worker_cannot_create_job()
    {
        $user = $this->createUser('worker');
        $project = factory(Project::class)->create();

        $this->postJson(route('api.jobs.store'), [
            'project_id' => $project->id,
            'name' => 'Test Job',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }
}
