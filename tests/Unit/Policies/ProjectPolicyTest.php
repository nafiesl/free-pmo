<?php

namespace Tests\Unit\Policies;

use App\Entities\Agencies\Agency;
use App\Entities\Projects\Project;
use Tests\TestCase as TestCase;

class ProjectPolicyTest extends TestCase
{
    /** @test */
    public function user_can_create_project()
    {
        $user   = $this->userSigningIn();
        $agency = factory(Agency::class)->create(['owner_id' => $user->id]);

        $this->assertTrue($user->can('create', new Project));
    }

    /** @test */
    public function user_can_view_project()
    {
        $user    = $this->userSigningIn();
        $agency  = factory(Agency::class)->create(['owner_id' => $user->id]);
        $project = factory(Project::class)->create(['owner_id' => $agency->id]);

        $this->assertTrue($user->can('view', $project));
    }

    /** @test */
    public function user_can_update_project()
    {
        $user    = $this->userSigningIn();
        $agency  = factory(Agency::class)->create(['owner_id' => $user->id]);
        $project = factory(Project::class)->create(['owner_id' => $agency->id]);

        $this->assertTrue($user->can('update', $project));
    }

    /** @test */
    public function user_can_delete_project()
    {
        $user    = $this->userSigningIn();
        $agency  = factory(Agency::class)->create(['owner_id' => $user->id]);
        $project = factory(Project::class)->create(['owner_id' => $agency->id]);

        $this->assertTrue($user->can('delete', $project));
    }
}
