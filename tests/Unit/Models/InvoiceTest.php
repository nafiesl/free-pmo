<?php

namespace Tests\Unit\Models;

use App\Entities\Invoices\Invoice;
use App\Entities\Projects\Project;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /** @test */
    public function it_has_project_relation()
    {
        $user    = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['owner_id' => $user->agency->id]);
        $invoice = factory(Invoice::class)->create(['project_id' => $project->id]);

        $this->assertTrue($invoice->project instanceof Project);
        $this->assertEquals($invoice->project->id, $project->id);
    }

    /** @test */
    public function it_generates_its_own_number()
    {
        $invoice1 = factory(Invoice::class)->create();
        $this->assertEquals(date('ym').'001', $invoice1->number);

        $invoice2 = factory(Invoice::class)->create();
        $this->assertEquals(date('ym').'002', $invoice2->number);
    }
}
