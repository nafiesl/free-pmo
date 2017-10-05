<?php

namespace App\Services\InvoiceDrafts;

use App\Product;
use Illuminate\Support\Collection;

/**
 * InvoiceDraft Collection Class.
 */
class InvoiceDraftCollection
{
    private $instance;
    private $session;

    public function __construct()
    {
        $this->session = session();
        $this->instance('drafts');
    }

    public function instance($instance = null)
    {
        $instance = $instance ?: 'drafts';

        $this->instance = sprintf('%s.%s', 'invoices', $instance);

        return $this;
    }

    public function currentInstance()
    {
        return str_replace('invoices.', '', $this->instance);
    }

    public function add(InvoiceDraft $draft)
    {
        $content = $this->getContent();
        $draft->draftKey = str_random(10);
        $content->put($draft->draftKey, $draft);

        $this->session->put($this->instance, $content);

        return $draft;
    }

    public function get($draftKey)
    {
        $content = $this->getContent();
        if (isset($content[$draftKey])) {
            return $content[$draftKey];
        }
    }

    public function updateDraftAttributes($draftKey, $draftAttributes)
    {
        $content = $this->getContent();

        $content[$draftKey]->projectId = $draftAttributes['project_id'];
        $content[$draftKey]->notes = $draftAttributes['notes'];

        $this->session->put($this->instance, $content);

        return $content[$draftKey];
    }

    public function emptyDraft($draftKey)
    {
        $content = $this->getContent();
        $content[$draftKey]->empty();
        $this->session->put($this->instance, $content);
    }

    public function removeDraft($draftKey)
    {
        $content = $this->getContent();
        $content->pull($draftKey);
        $this->session->put($this->instance, $content);
    }

    public function content()
    {
        return $this->getContent();
    }

    protected function getContent()
    {
        $content = $this->session->has($this->instance) ? $this->session->get($this->instance) : collect([]);

        return $content;
    }

    public function keys()
    {
        return $this->getContent()->keys();
    }

    public function destroy()
    {
        $this->session->remove($this->instance);
    }

    public function addItemToDraft($draftKey, Item $item)
    {
        $content = $this->getContent();
        $content[$draftKey]->addItem($item);

        $this->session->put($this->instance, $content);

        return $item;
    }

    public function draftHasItem(TrasactionDraft $draft, Product $product)
    {
        $item = $draft->search($product);

        return !is_null($item);
    }

    public function updateDraftItem($draftKey, $itemKey, $newItemData)
    {
        $content = $this->getContent();
        $content[$draftKey]->updateItem($itemKey, $newItemData);

        $this->session->put($this->instance, $content);
    }

    public function removeItemFromDraft($draftKey, $itemKey)
    {
        $content = $this->getContent();
        $content[$draftKey]->removeItem($itemKey);

        $this->session->put($this->instance, $content);
    }

    public function count()
    {
        return $this->getContent()->count();
    }

    public function isEmpty()
    {
        return $this->count() == 0;
    }

    public function hasContent()
    {
        return !$this->isEmpty();
    }
}
