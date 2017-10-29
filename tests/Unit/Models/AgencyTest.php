<?php

namespace Tests\Unit\Models;

use App\Entities\Agencies\Agency;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AgencyTest extends TestCase
{
    /** @test */
    public function agency_has_an_owner()
    {
        $agency = factory(Agency::class)->create();
        $this->assertTrue($agency->owner instanceof User);
    }

    /** @test */
    public function agency_has_many_projects()
    {
        $agency  = factory(Agency::class)->create();
        $project = factory(Project::class)->create(['owner_id' => $agency->id]);

        $this->assertTrue($agency->projects instanceof Collection);
        $this->assertTrue($agency->projects->first() instanceof Project);
    }
}
