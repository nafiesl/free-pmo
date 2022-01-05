<?php

namespace Tests\Unit\Models;

use App\Entities\Invoices\Invoice;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Invoice Model Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_project_relation()
    {
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $invoice = factory(Invoice::class)->create(['project_id' => $project->id]);

        $this->assertInstanceOf(Project::class, $invoice->project);
        $this->assertEquals($invoice->project->id, $project->id);
    }

    /** @test */
    public function it_has_creator_relation()
    {
        $user = $this->adminUserSigningIn();
        $invoice = factory(Invoice::class)->create(['creator_id' => $user->id]);

        $this->assertInstanceOf(User::class, $invoice->creator);
        $this->assertEquals($invoice->creator->id, $user->id);
    }

    /** @test */
    public function it_generates_its_own_number()
    {
        $invoice1 = factory(Invoice::class)->create();
        $this->assertEquals(date('ym').'001', $invoice1->number);

        $invoice2 = factory(Invoice::class)->create();
        $this->assertEquals(date('ym').'002', $invoice2->number);
    }

    /** @test */
    public function it_has_number_link_method()
    {
        $invoice = factory(Invoice::class)->make();

        $this->assertEquals(
            link_to_route('invoices.show', $invoice->number, [$invoice->number], [
                'title' => __(
                    'app.show_detail_title',
                    ['name' => $invoice->number, 'type' => __('invoice.invoice')]
                ),
            ]), $invoice->numberLink()
        );
    }
}
