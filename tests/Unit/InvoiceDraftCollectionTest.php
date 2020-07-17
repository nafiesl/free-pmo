<?php

namespace Tests\Unit;

use App\Services\InvoiceDrafts\InvoiceDraft;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use App\Services\InvoiceDrafts\Item;
use Tests\TestCase;

class InvoiceDraftCollectionTest extends TestCase
{
    /** @test */
    public function it_has_a_default_instance()
    {
        $cart = new InvoiceDraftCollection();
        $this->assertEquals('drafts', $cart->currentInstance());
    }

    /** @test */
    public function it_can_have_multiple_instances()
    {
        $cart = new InvoiceDraftCollection();

        $draft = new InvoiceDraft();

        $cart->add($draft);
        $cart->instance('wishlist')->add($draft);

        $this->assertCount(1, $cart->instance('drafts')->content());
        $this->assertCount(1, $cart->instance('wishlist')->content());
    }

    /** @test */
    public function cart_collection_consist_of_invoice_draft()
    {
        $cart = new InvoiceDraftCollection();
        $draft = new InvoiceDraft();

        $cart->add($draft);

        $this->assertCount(1, $cart->content());
        $this->assertTrue($cart->hasContent());
    }

    /** @test */
    public function it_can_get_a_draft_by_key()
    {
        $draft = new InvoiceDraft();
        $cart = new InvoiceDraftCollection();

        $cart->add($draft);
        $gottenDraft = $cart->get($draft->draftKey);
        $invalidDraft = $cart->get('random_key');

        $this->assertEquals($draft, $gottenDraft);
        $this->assertNull($invalidDraft);
    }

    /** @test */
    public function it_can_remove_draft_from_draft_collection()
    {
        $cart = new InvoiceDraftCollection();
        $draft = new InvoiceDraft();

        $cart->add($draft);

        $this->assertCount(1, $cart->content());
        $cart->removeDraft($cart->content()->keys()->last());
        $this->assertCount(0, $cart->content());
    }

    /** @test */
    public function it_can_be_empty_out()
    {
        $cart = new InvoiceDraftCollection();

        $draft = new InvoiceDraft();

        $cart->add($draft);
        $cart->add($draft);
        $cart->add($draft);

        $this->assertCount(3, $cart->content());
        $cart->destroy();

        $this->assertCount(0, $cart->content());
        $this->assertTrue($cart->isEmpty());
    }

    /** @test */
    public function it_has_content_keys()
    {
        $cart = new InvoiceDraftCollection();

        $draft = new InvoiceDraft();

        $cart->add($draft);

        $this->assertCount(1, $cart->keys());
        $cart->removeDraft($cart->content()->keys()->last());
        $this->assertCount(0, $cart->keys());
    }

    /** @test */
    public function it_can_add_item_to_draft()
    {
        $cart = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());
        $item = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);

        $cart->addItemToDraft($draft->draftKey, $item);
        $cart->addItemToDraft($draft->draftKey, $item);
        $this->assertEquals(2000, $draft->getTotal());
        $this->assertEquals(2, $draft->getItemsCount());
    }

    /** @test */
    public function it_can_remove_item_from_draft()
    {
        $cart = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());
        $item = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);

        $cart->addItemToDraft($draft->draftKey, $item);
        $this->assertCount(1, $draft->items());
        $cart->removeItemFromDraft($draft->draftKey, 0);
        $this->assertCount(0, $draft->items());
        $this->assertEquals(0, $draft->getTotal());
    }

    /** @test */
    public function it_can_update_an_item_of_draft()
    {
        $cart = new InvoiceDraftCollection();

        $draft = $cart->add(new InvoiceDraft());
        $item = new Item(['description' => 'Deskripsi item invoice', 'amount' => 1000]);

        $cart->addItemToDraft($draft->draftKey, $item);
        $this->assertCount(1, $draft->items());
        $this->assertEquals(1000, $draft->getTotal());

        $newItemData = [
            'amount' => 100,
        ];

        $cart->updateDraftItem($draft->draftKey, 0, $newItemData);
        $this->assertEquals(100, $draft->getTotal());
    }
}
