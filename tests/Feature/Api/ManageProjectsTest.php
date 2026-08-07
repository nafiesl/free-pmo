<?php

namespace Tests\Feature\Api;

use App\Entities\Partners\Customer;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_new_project()
    {
        $user = $this->createUser('admin');
        $customer = factory(Customer::class)->create();

        $this->postJson(route('api.projects.store'), [
            'name' => 'Test Project',
            'description' => 'Project description',
            'customer_id' => $customer->id,
            'proposal_value' => 5000000,
            'status_id' => 1,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeJson(['message' => __('project.created')]);
        $this->seeInDatabase('projects', ['name' => 'Test Project']);
    }

    /** @test */
    public function admin_can_create_project_with_new_customer()
    {
        $user = $this->createUser('admin');

        $this->postJson(route('api.projects.store'), [
            'name' => 'Test Project',
            'customer_name' => 'New Customer',
            'customer_email' => 'new@example.com',
            'proposal_value' => 5000000,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(201);
        $this->seeInDatabase('customers', ['name' => 'New Customer']);
        $this->seeInDatabase('projects', ['name' => 'Test Project']);
    }

    /** @test */
    public function admin_can_update_project()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->patchJson(route('api.projects.update', $project), [
            'name' => 'Updated Project',
            'proposal_value' => 6000000,
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('project.updated')]);
        $this->seeInDatabase('projects', ['id' => $project->id, 'name' => 'Updated Project']);
    }

    /** @test */
    public function admin_can_delete_project()
    {
        $user = $this->createUser('admin');
        $project = factory(Project::class)->create();

        $this->deleteJson(route('api.projects.destroy', $project), [], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson(['message' => __('project.deleted')]);
        $this->dontSeeInDatabase('projects', ['id' => $project->id]);
    }

    /** @test */
    public function worker_cannot_create_project()
    {
        $user = $this->createUser('worker');

        $this->postJson(route('api.projects.store'), [
            'name' => 'Test Project',
        ], [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_create_project()
    {
        $this->postJson(route('api.projects.store'), [
            'name' => 'Test Project',
        ]);

        $this->seeStatusCode(401);
    }
}
