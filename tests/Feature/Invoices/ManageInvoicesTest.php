<?php

namespace Tests\Feature\Invoices;

use App\Entities\Invoices\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Manage Invoices Feature Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ManageInvoicesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_browse_invoice_list_page()
    {
        $this->adminUserSigningIn();

        $invoice = factory(Invoice::class)->create();

        $this->visit(route('invoices.index'));

        $this->seePageIs(route('invoices.index'));
        $this->see(__('invoice.list'));
        $this->see($invoice->number);
    }

    /** @test */
    public function user_can_edit_invoice_data()
    {
        $this->adminUserSigningIn();
        $invoice = factory(Invoice::class)->create();

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm(__('invoice.update'), [
            'project_id' => $invoice->project_id,
            'date'       => '2011-01-01',
            'due_date'   => '2011-01-30',
            'notes'      => 'Catatan invoice 123',
        ]);

        $this->see(__('invoice.updated'));
        $this->seePageIs(route('invoices.show', $invoice));

        $this->seeInDatabase('invoices', [
            'id'       => $invoice->id,
            'notes'    => 'Catatan invoice 123',
            'date'     => '2011-01-01',
            'due_date' => '2011-01-30',
        ]);
    }

    /** @test */
    public function user_can_edit_invoice_with_additional_discount()
    {
        $this->adminUserSigningIn();
        $invoice = factory(Invoice::class)->create([
            'date'     => '2010-10-10',
            'due_date' => '2010-10-30',
            'amount'   => 3000,
            'items'    => [
                ['description' => 'Deskripsi item invoice', 'amount' => 1000],
                ['description' => 'Deskripsi item invoice', 'amount' => 2000],
            ],
        ]);

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm(__('invoice.update'), [
            'project_id'     => $invoice->project_id,
            'date'           => '2011-01-01',
            'due_date'       => '2011-01-30',
            'discount'       => 500,
            'discount_notes' => 'Diskon 500.',
            'notes'          => 'Catatan invoice 123',
        ]);

        $this->see(__('invoice.updated'));
        $this->seePageIs(route('invoices.show', $invoice));

        $this->seeInDatabase('invoices', [
            'id'             => $invoice->id,
            'notes'          => 'Catatan invoice 123',
            'date'           => '2011-01-01',
            'due_date'       => '2011-01-30',
            'amount'         => 2500,
            'discount'       => 500,
            'discount_notes' => 'Diskon 500.',
        ]);
    }

    /** @test */
    public function user_can_add_invoice_item_on_invoice_edit_page()
    {
        $this->adminUserSigningIn();
        $invoice = factory(Invoice::class)->create();

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm(__('invoice.add_item'), [
            'new_item_description' => 'Testing deskripsi invoice item',
            'new_item_amount'      => 2000,
        ]);

        $this->see(__('invoice.item_added'));

        $this->submitForm(__('invoice.add_item'), [
            'new_item_description' => 'Testing deskripsi invoice item',
            'new_item_amount'      => 3000,
        ]);

        $this->see(__('invoice.item_added'));

        $this->seePageIs(route('invoices.edit', $invoice));

        $this->seeInDatabase('invoices', [
            'id'     => $invoice->id,
            'items'  => '[{"description":"Testing deskripsi invoice item","amount":"2000"},{"description":"Testing deskripsi invoice item","amount":"3000"}]',
            'amount' => 5000,
        ]);
    }

    /** @test */
    public function user_can_add_invoice_item_on_invoice_with_discount_and_sum_correct_amount()
    {
        $this->adminUserSigningIn();
        $invoice = factory(Invoice::class)->create([
            'discount' => 300,
        ]);

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm(__('invoice.add_item'), [
            'new_item_description' => 'Testing deskripsi invoice item',
            'new_item_amount'      => 2000,
        ]);

        $this->see(__('invoice.item_added'));

        $this->seePageIs(route('invoices.edit', $invoice));

        $this->seeInDatabase('invoices', [
            'id'       => $invoice->id,
            'amount'   => 1700,
            'discount' => 300,
        ]);
    }

    /** @test */
    public function user_can_update_invoice_item_on_invoice_edit_page()
    {
        $this->adminUserSigningIn();

        $invoice = factory(Invoice::class)->create([
            'items' => [
                ['description' => 'Testing deskripsi invoice item', 'amount' => '1111'],
                ['description' => 'Testing deskripsi invoice item', 'amount' => '2222'],
            ],
        ]);

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm('update-item-1', [
            'item_key[1]'    => 1,
            'description[1]' => 'Testing deskripsi Update',
            'amount[1]'      => 100,
        ]);

        $this->see(__('invoice.item_updated'));

        $this->seePageIs(route('invoices.edit', $invoice));

        $this->seeInDatabase('invoices', [
            'id'     => $invoice->id,
            'items'  => '[{"description":"Testing deskripsi invoice item","amount":"1111"},{"description":"Testing deskripsi Update","amount":"100"}]',
            'amount' => 1211,
        ]);
    }

    /** @test */
    public function user_can_update_invoice_item_on_invoice_with_discount_and_sum_correct_amount()
    {
        $this->adminUserSigningIn();

        $invoice = factory(Invoice::class)->create([
            'items'    => [
                ['description' => 'Testing deskripsi invoice item', 'amount' => '1111'],
                ['description' => 'Testing deskripsi invoice item', 'amount' => '2222'],
            ],
            'discount' => 50,
        ]);

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm('update-item-1', [
            'item_key[1]'    => 1,
            'description[1]' => 'Testing deskripsi Update',
            'amount[1]'      => 100,
        ]);

        $this->see(__('invoice.item_updated'));

        $this->seePageIs(route('invoices.edit', $invoice));

        $this->seeInDatabase('invoices', [
            'id'     => $invoice->id,
            'items'  => '[{"description":"Testing deskripsi invoice item","amount":"1111"},{"description":"Testing deskripsi Update","amount":"100"}]',
            'amount' => 1161,
        ]);
    }

    /** @test */
    public function user_can_remove_invoice_item_on_invoice_edit_page()
    {
        $this->adminUserSigningIn();

        $invoice = factory(Invoice::class)->create([
            'items' => [
                ['description' => 'Testing deskripsi invoice item', 'amount' => '1111'],
                ['description' => 'Testing deskripsi invoice item', 'amount' => '2222'],
            ],
        ]);

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm('remove-item-1', [
            'item_index' => 1,
        ]);

        $this->see(__('invoice.item_removed'));

        $this->seePageIs(route('invoices.edit', $invoice));

        $this->seeInDatabase('invoices', [
            'id'     => $invoice->id,
            'items'  => '[{"description":"Testing deskripsi invoice item","amount":"1111"}]',
            'amount' => 1111,
        ]);
    }

    /** @test */
    public function user_can_remove_invoice_item_on_invoice_with_discount_and_sum_correct_amount()
    {
        $this->adminUserSigningIn();

        $invoice = factory(Invoice::class)->create([
            'items'    => [
                ['description' => 'Testing deskripsi invoice item', 'amount' => '1111'],
                ['description' => 'Testing deskripsi invoice item', 'amount' => '2222'],
            ],
            'discount' => 50,
        ]);

        $this->visit(route('invoices.edit', $invoice));

        $this->submitForm('remove-item-1', [
            'item_index' => 1,
        ]);

        $this->see(__('invoice.item_removed'));

        $this->seePageIs(route('invoices.edit', $invoice));

        $this->seeInDatabase('invoices', [
            'id'     => $invoice->id,
            'items'  => '[{"description":"Testing deskripsi invoice item","amount":"1111"}]',
            'amount' => 1061,
        ]);
    }

    /** @test */
    public function user_can_delete_an_invoice()
    {
        $this->adminUserSigningIn();
        $invoice = factory(Invoice::class)->create();

        $this->visit(route('invoices.edit', $invoice));

        $this->click(__('invoice.delete'));
        $this->seePageIs(route('invoices.edit', [$invoice, 'action' => 'delete']));

        $this->submitForm(__('invoice.delete'), [
            'invoice_id' => $invoice->id,
        ]);

        $this->see(__('invoice.deleted'));

        $this->seePageIs(route('projects.invoices', $invoice->project_id));

        $this->dontSeeInDatabase('invoices', [
            'id' => $invoice->id,
        ]);
    }
}
