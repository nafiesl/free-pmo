<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Project;
use Tests\TestCase;

class ApiManageProjectsTest extends TestCase
{
    /** @test */
    public function user_can_get_project_lists()
    {
        $user    = $this->adminUserSigningIn();
        $project = factory(Project::class, 1)->create(['owner_id' => $user->agency->id]);

        $this->getJson(route('api.projects.index'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }
}
