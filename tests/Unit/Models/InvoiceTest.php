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
        $invoice = factory(Invoice::class)->create();
        $this->assertTrue($invoice->project instanceof Project);
    }

    /** @test */
    public function it_generates_its_own_number()
    {
        $invoice1 = factory(Invoice::class)->create();
        $this->assertEquals(date('ym') . '001', $invoice1->number);

        $invoice2 = factory(Invoice::class)->create();
        $this->assertEquals(date('ym') . '002', $invoice2->number);
    }
}
