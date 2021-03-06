<?php

namespace Tests\Unit\Models;

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
        $project = factory(Project::class)->create(['name' => 'New Project']);

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
}
