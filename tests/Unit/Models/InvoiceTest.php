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
}
