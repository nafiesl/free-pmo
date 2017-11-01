<?php

namespace Tests\Feature;

use App\Entities\Partners\Customer;
use App\Entities\Projects\Project;
use App\Services\InvoiceDrafts\InvoiceDraft;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use App\Services\InvoiceDrafts\Item;
use Tests\TestCase;

class InvoiceEntryTest extends TestCase
{
    /** @test */
    public function user_can_visit_invoice_drafts_page()
    {
        $this->adminUserSigningIn();

        // Add new draft to collection
        $cart  = new InvoiceDraftCollection();
        $draft = $cart->add(new InvoiceDraft());

        $this->visit(route('invoices.create'));

        $this->assertViewHas('draft', $draft);
    }

    /** @test */
    public function user_can_create_invoice_draft_by_invoice_create_button()
    {
        $this->adminUserSigningIn();
        $this->visit(route('invoices.create'));

        $this->press(trans('invoice.create'));
        $cart  = new InvoiceDraftCollection();
        $draft = $cart->content()->last();
        $this->seePageIs(route('invoices.create', $draft->draftKey));
    }

    /** @test */
    public function user_can_add_item_to_cash_draft()
    {
        $this->adminUserSigningIn();

        $cart  = new InvoiceDraftCollection();
        $draft = new InvoiceDraft();
        $cart->add($draft);

        $this->visit(route('invoices.create', [$draft->draftKey]));

        $this->type('Testing deskripsi invoice item', 'description');
        $this->type(2000, 'amount');
        $this->press('add-item');

        $this->see(trans('invoice.item_added'));

        $this->type('Testing deskripsi invoice item', 'description');
        $this->type(3000, 'amount');
        $this->press('add-item');

        $this->seePageIs(route('invoices.create', $draft->draftKey));
        $this->assertEquals(5000, $draft->getTotal());
        $this->see(formatRp(5000));
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
        $this->visit(route('invoices.create', $draft->draftKey));

        $this->submitForm('update-item-0', [
            'item_key'    => 0,
            'description' => 'Testing deskripsi Update',
            'amount'      => 100,
        ]);

        $this->submitForm('update-item-1', [
            'item_key'    => 1,
            'description' => 'Testing deskripsi Update',
            'amount'      => 100,
        ]);

        $this->assertEquals(200, $draft->getTotal());

        $this->see(formatRp($draft->getTotal()));
    }

    /** @test */
    public function user_can_update_draft_invoice_detail_and_get_confirm_page()
    {
        $user    = $this->adminUserSigningIn();
        $project = factory(Project::class)->create(['owner_id' => $user->agency->id]);
        $cart    = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());

        $item1 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);
        $item2 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 2000]);

        // Add items to draft
        $cart->addItemToDraft($draft->draftKey, $item1);
        $cart->addItemToDraft($draft->draftKey, $item2);

        $this->visit(route('invoices.create', $draft->draftKey));

        $this->type($project->id, 'project_id');
        $this->type('catatan', 'notes');
        $this->press(trans('invoice.proccess'));

        $this->seePageIs(route('invoices.create', [$draft->draftKey, 'action' => 'confirm']));

        $this->see(trans('invoice.confirm'));
        $this->see($project->name);
        $this->see($draft->notes);
        $this->see(formatRp(3000));
        $this->seeElement('input', ['id' => 'save-invoice-draft']);
    }

    /** @test */
    public function user_can_save_invoice_if_draft_is_completed()
    {
        $cart = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());

        $item1 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);
        $item2 = new Item(['description' => 'Deskripsi item invoice', 'amount' => 2000]);

        $user     = $this->adminUserSigningIn();
        $customer = factory(Customer::class)->create(['owner_id' => $user->agency->id]);
        $project  = factory(Project::class)->create(['owner_id' => $user->agency->id, 'customer_id' => $customer->id]);

        // Add items to draft
        $cart->addItemToDraft($draft->draftKey, $item1);
        $cart->addItemToDraft($draft->draftKey, $item2);

        $draftAttributes = [
            'project_id' => $project->id,
            'notes'      => 'Catatan',
        ];
        $cart->updateDraftAttributes($draft->draftKey, $draftAttributes);

        $this->visit(route('invoices.create', [$draft->draftKey, 'action' => 'confirm']));

        $this->press(trans('invoice.save'));

        // $this->seePageIs(route('invoices.show', date('ym').'0001'));
        // $this->see(trans('invoice.created', ['invoice_no' => date('ym').'0001']));

        $this->seeInDatabase('invoices', [
            'number'     => date('ym').'001',
            'items'      => '[{"description":"Deskripsi item invoice","amount":1000},{"description":"Deskripsi item invoice","amount":2000}]',
            'project_id' => $project->id,
            'amount'     => 3000,
            'notes'      => 'Catatan',
            'creator_id' => $user->id,
            'status_id'  => 1,
        ]);
    }
}
