<?php

namespace Tests\Feature\Invoices;

use Tests\TestCase;

class ManageInvoiceTest extends TestCase
{
    /** @test */
    public function user_can_browse_invoice_list_page()
    {
        $this->adminUserSigningIn();

        $this->visit(route('invoices.index'));

        $this->seePageIs(route('invoices.index'));
        $this->see(trans('invoice.list'));
    }
}
