<?php

namespace Tests\Feature\Api;

use App\Entities\Projects\Project;
use Tests\TestCase;

/**
 * Manage Projects API Feature Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ApiManageProjectsTest extends TestCase
{
    /** @test */
    public function user_can_get_project_lists()
    {
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class, 1)->create();

        $this->getJson(route('api.projects.index'), [
            'Authorization' => 'Bearer '.$user->api_token,
        ]);

        $this->seeStatusCode(200);
    }
}
