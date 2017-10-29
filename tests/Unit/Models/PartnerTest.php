<?php

namespace Tests\Unit\Models;

use App\Entities\Agencies\Agency;
use App\Entities\Partners\Partner;
use App\Entities\Projects\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase as TestCase;

class PartnerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_partner_has_an_owner()
    {
        $agency  = factory(Agency::class)->create();
        $partner = factory(Partner::class)->create(['owner_id' => $agency->id]);

        $this->assertTrue($partner->owner instanceof Agency);
        $this->assertEquals($partner->owner->id, $agency->id);
    }

    /** @test */
    public function a_partner_has_many_projects()
    {
        $partner = factory(Partner::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $partner->id]);

        $this->assertTrue($partner->projects instanceof Collection);
        $this->assertTrue($partner->projects->first() instanceof Project);
    }
}
