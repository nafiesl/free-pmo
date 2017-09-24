<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Tests\TestCase;

class ApiManageProjectsTest extends TestCase
{
    /** @test */
    public function user_can_get_project_lists()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class, 5)->create(['owner_id' => $user->id]);

        $this->getJson(route('api.projects.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeStatusCode(200);
    }
}
