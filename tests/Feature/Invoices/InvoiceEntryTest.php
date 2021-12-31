<?php

namespace Tests\Feature\Invoices;

use App\Entities\Partners\Customer;
use App\Entities\Projects\Project;
use App\Services\InvoiceDrafts\InvoiceDraft;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use App\Services\InvoiceDrafts\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Invoice Entry Feature Test.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class InvoiceEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_visit_invoice_drafts_page()
    {
        $this->adminUserSigningIn();

        // Add new draft to collection
        $cart = new InvoiceDraftCollection();
        $draft = $cart->add(new InvoiceDraft());

        $this->visit(route('invoice-drafts.index'));

        $this->assertViewHas('draft', $draft);
    }

    /** @test */
    public function user_can_create_invoice_draft_by_invoice_create_button()
    {
        $this->adminUserSigningIn();
        $this->visit(route('invoice-drafts.index'));

        $this->press(__('invoice.create'));
        $cart = new InvoiceDraftCollection();
        $draft = $cart->content()->last();
        $this->seePageIs(route('invoice-drafts.show', $draft->draftKey));
    }

    /** @test */
    public function user_can_create_invoice_draft_from_project_invoices_page()
    {
        $this->adminUserSigningIn();
        $project = factory(Project::class)->create();

        $this->visit(route('projects.invoices', $project));

        $this->press(__('invoice.create'));

        $cart = new InvoiceDraftCollection();
        $draft = $cart->content()->last();

        $this->assertEquals($draft->projectId, $project->id);
        $this->seePageIs(route('invoice-drafts.show', $draft->draftKey));
        $this->see($project->name);
        $this->see($project->customer->name);
    }

    /** @test */
    public function user_can_add_item_to_invoice_draft()
    {
        $this->adminUserSigningIn();

        $cart = new InvoiceDraftCollection();
        $draft = new InvoiceDraft();
        $cart->add($draft);

        $this->visit(route('invoice-drafts.show', $draft->draftKey));

        $this->type('Testing deskripsi invoice item', 'new_item_description');
        $this->type(2000, 'new_item_amount');
        $this->press(__('invoice.add_item'));

        $this->see(__('invoice.item_added'));

        $this->type('Testing deskripsi invoice item', 'new_item_description');
        $this->type(3000, 'new_item_amount');
        $this->press(__('invoice.add_item'));

        $this->seePageIs(route('invoice-drafts.show', $draft->draftKey));
        $this->see(format_money(5000));
    }

    /** @test */
    public function user_can_remove_an_invoice_draft()
    {
        $this->adminUserSigningIn();

        $cart = new InvoiceDraftCollection();
        $draft = new InvoiceDraft();
        $cart->add($draft);

        $this->visit(route('invoice-drafts.show', $draft->draftKey));
        $this->press('remove_draft_'.$draft->draftKey);

        $this->seePageIs(route('invoice-drafts.index'));
        $this->assertTrue($cart->isEmpty());
    }

    /** @test */
    public function user_can_update_item_attribute()
    {
        $cart = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());

        $item1 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);
        $item2 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 2000]);

        // Add items to draft
        $cart->addItemToDraft($draft->draftKey, $item1);
        $cart->addItemToDraft($draft->draftKey, $item2);

        $this->adminUserSigningIn();
        $this->visit(route('invoice-drafts.show', $draft->draftKey));

        $this->submitForm('update-item-0', [
            'item_key[0]' => 0,
            'description[0]' => 'Testing deskripsi Update',
            'amount[0]' => 100,
        ]);

        $this->submitForm('update-item-1', [
            'item_key[1]' => 1,
            'description[1]' => 'Testing deskripsi Update',
            'amount[1]' => 100,
        ]);

        $this->see(format_money(200));
    }

    /** @test */
    public function user_can_update_draft_invoice_detail_and_get_confirm_page()
    {
        $user = $this->adminUserSigningIn();
        $project = factory(Project::class)->create();
        $cart = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());

        $item1 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);
        $item2 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 2000]);

        // Add items to draft
        $cart->addItemToDraft($draft->draftKey, $item1);
        $cart->addItemToDraft($draft->draftKey, $item2);

        $this->visit(route('invoice-drafts.show', $draft->draftKey));

        $this->submitForm(__('invoice.proccess'), [
            'project_id' => $project->id,
            'date' => '2017-01-01',
            'due_date' => '2017-01-30',
            'notes' => 'catatan',
        ]);

        $this->seePageIs(route('invoice-drafts.show', [$draft->draftKey, 'action' => 'confirm']));

        $this->see(__('invoice.confirm_instruction', [
            'back_link' => link_to_route('invoice-drafts.show', __('app.back'), $draft->draftKey),
        ]));

        $this->see($project->name);
        $this->see($project->customer->name);
        $this->see($draft->notes);
        $this->see(format_money(3000));
        $this->seeElement('input', ['id' => 'save-invoice-draft']);
    }

    /** @test */
    public function user_can_save_invoice_if_draft_is_completed()
    {
        $cart = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());

        $item1 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);
        $item2 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 2000]);

        $user = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);

        // Add items to draft
        $cart->addItemToDraft($draft->draftKey, $item1);
        $cart->addItemToDraft($draft->draftKey, $item2);

        $draftAttributes = [
            'project_id' => $project->id,
            'date' => '2010-10-10',
            'due_date' => '2010-10-30',
            'notes' => 'Catatan',
        ];
        $cart->updateDraftAttributes($draft->draftKey, $draftAttributes);

        $this->visit(route('invoice-drafts.show', [$draft->draftKey, 'action' => 'confirm']));

        $this->press(__('invoice.save'));

        $this->seePageIs(route('invoices.show', date('ym').'001'));
        $this->see(__('invoice.created', ['invoice_no' => date('ym').'001']));

        $this->seeInDatabase('invoices', [
            'project_id' => $project->id,
            'number' => date('ym').'001',
            'date' => '2010-10-10',
            'due_date' => '2010-10-30',
            'items' => '[{"description":"Deskripsi item invoice","amount":1000},{"description":"Deskripsi item invoice","amount":2000}]',
            'amount' => 3000,
            'notes' => 'Catatan',
            'status_id' => 1,
            'creator_id' => $user->id,
        ]);
    }
}
