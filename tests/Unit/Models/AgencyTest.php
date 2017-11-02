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
        $this->assertInstanceOf(User::class, $agency->owner);
    }

    /** @test */
    public function agency_has_many_projects()
    {
        $agency  = factory(Agency::class)->create();
        $project = factory(Project::class)->create(['owner_id' => $agency->id]);

        $this->assertInstanceOf(Collection::class, $agency->projects);
        $this->assertInstanceOf(Project::class, $agency->projects->first());
    }

    /** @test */
    public function agency_can_has_many_workers()
    {
        $agency  = factory(Agency::class)->create();
        $workers = factory(User::class, 2)->create();

        $agency->addWorker($workers[0]);
        $agency->addWorker($workers[1]);

        $this->assertCount(2, $agency->workers);
        $this->assertInstanceOf(Collection::class, $agency->workers);
        $this->assertInstanceOf(User::class, $agency->workers->first());
    }

    /** @test */
    public function agency_can_remove_some_workers()
    {
        $agency  = factory(Agency::class)->create();
        $workers = factory(User::class, 2)->create();

        $agency->addWorker($workers[0]);
        $agency->addWorker($workers[1]);

        $this->assertCount(2, $agency->workers);

        $agency->removeWorker($workers[0]);

        $agency = $agency->fresh();
        $this->assertCount(1, $agency->workers);
        $this->assertEquals($workers[1]->id, $agency->workers->first()->id);
    }
}
