<?php

namespace Tests\Feature\Invoices;

use App\Entities\Invoices\Invoice;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Invoice Duplicate Feature Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class InvoiceDuplicateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_invoice_draft_by_duplicate_existing_invoice()
    {
        $this->adminUserSigningIn();
        $invoice = factory(Invoice::class)->create([
            'items' => [
                [
                    'description' => 'Item 1 description',
                    'amount' => 100000,
                ],
                [
                    'description' => 'Item 1 description',
                    'amount' => 150000,
                ],
            ],
        ]);
        $this->visit(route('invoices.show', $invoice));

        $this->press(__('invoice.duplicate'));
        $invoiceDrafts = new InvoiceDraftCollection();
        $draft = $invoiceDrafts->content()->last();
        $this->seePageIs(route('invoice-drafts.show', $draft->draftKey));
    }
}
