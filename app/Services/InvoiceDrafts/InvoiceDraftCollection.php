<?php

namespace App\Services\InvoiceDrafts;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Invoice Draft Collection Class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoiceDraftCollection
{
    /**
     * Instance of invoice draft.
     *
     * @var string
     */
    private $instance;

    /**
     * Laravel session.
     *
     * @var \Illuminate\Session\SessionManager
     */
    private $session;

    /**
     * Create new invoice draft instance.
     */
    public function __construct()
    {
        $this->session = session();
        $this->instance('drafts');
    }

    /**
     * Set new instance name of invoice draft.
     *
     * @param  string  $instance  Invoice draft instance name.
     * @return \App\Services\InvoiceDrafts\InvoiceDraft
     */
    public function instance($instance = null)
    {
        $instance = $instance ?: 'drafts';

        $this->instance = sprintf('%s.%s', 'invoices', $instance);

        return $this;
    }

    /**
     * Get instance name of current invoice draft.
     *
     * @return string
     */
    public function currentInstance()
    {
        return str_replace('invoices.', '', $this->instance);
    }

    /**
     * Add new invoice draft.
     *
     * @param  \App\Services\InvoiceDrafts\InvoiceDraft  $draft  Invoice draft.
     */
    public function add(InvoiceDraft $draft)
    {
        $content = $this->getContent();
        $draft->draftKey = Str::random(10);
        $content->put($draft->draftKey, $draft);

        $this->session->put($this->instance, $content);

        return $draft;
    }

    /**
     * Get an invoice draft.
     *
     * @param  string  $draftKey  The invoice draft key.
     * @return null|\App\Services\InvoiceDrafts\InvoiceDraft
     */
    public function get($draftKey)
    {
        $content = $this->getContent();
        if (isset($content[$draftKey])) {
            return $content[$draftKey];
        }
    }

    /**
     * Update invoice draft attribute.
     *
     * @param  string  $draftKey  Invoice draft key.
     * @param  array  $draftAttributes  Invoice draft attribute to be updated.
     * @return \App\Services\InvoiceDrafts\InvoiceDraft
     */
    public function updateDraftAttributes($draftKey, $draftAttributes)
    {
        $content = $this->getContent();

        $content[$draftKey]->date = $draftAttributes['date'];
        $content[$draftKey]->notes = $draftAttributes['notes'];
        $content[$draftKey]->dueDate = $draftAttributes['due_date'];
        $content[$draftKey]->projectId = $draftAttributes['project_id'];

        $this->session->put($this->instance, $content);

        return $content[$draftKey];
    }

    /**
     * Empty out an invoice draft items.
     *
     * @param  string  $draftKey  Invoice draft key.
     * @return void
     */
    public function emptyDraft($draftKey)
    {
        $content = $this->getContent();
        $content[$draftKey]->empty();
        $this->session->put($this->instance, $content);
    }

    /**
     * Remove an invocie draft.
     *
     * @param  string  $draftKey  Invoice draft key.
     * @return void
     */
    public function removeDraft($draftKey)
    {
        $content = $this->getContent();
        $content->pull($draftKey);
        $this->session->put($this->instance, $content);
    }

    /**
     * Get invoice draft collection content.
     *
     * @return \Illuminate\Support\Collection
     */
    public function content()
    {
        return $this->getContent();
    }

    /**
     * Get invoice draft collection content.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getContent()
    {
        $content = $this->session->has($this->instance) ? $this->session->get($this->instance) : collect([]);

        return $content;
    }

    /**
     * Get invoice draft keys collection.
     *
     * @return \Illuminate\Support\Collection Collection of keys.
     */
    public function keys()
    {
        return $this->getContent()->keys();
    }

    /**
     * Destroy an invoice draft.
     *
     * @return void
     */
    public function destroy()
    {
        $this->session->remove($this->instance);
    }

    /**
     * Add an item to an invoice draft.
     *
     * @param  string  $draftKey  Invoice draft key.
     * @param  \App\Services\InvoiceDrafts\Item  $item  Invoice item.
     * @return \App\Services\InvoiceDrafts\Item.
     */
    public function addItemToDraft($draftKey, Item $item)
    {
        $content = $this->getContent();
        $content[$draftKey]->addItem($item);

        $this->session->put($this->instance, $content);

        return $item;
    }

    /**
     * Update invoice draft item attributes.
     *
     * @param  string  $draftKey  Invoice draft key.
     * @param  string  $itemKey  Invoice item key.
     * @param  array  $newItemData  Array of item attribute.
     * @return void
     */
    public function updateDraftItem($draftKey, $itemKey, $newItemData)
    {
        $content = $this->getContent();
        $content[$draftKey]->updateItem($itemKey, $newItemData);

        $this->session->put($this->instance, $content);
    }

    /**
     * Remove an invoice draft item.
     *
     * @param  string  $draftKey  Invoice draft key.
     * @param  string  $itemKey  Invoice item key.
     * @return void
     */
    public function removeItemFromDraft($draftKey, $itemKey)
    {
        $content = $this->getContent();
        $content[$draftKey]->removeItem($itemKey);

        $this->session->put($this->instance, $content);
    }

    /**
     * Get invoice drafts count.
     *
     * @return int
     */
    public function count()
    {
        return $this->getContent()->count();
    }

    /**
     * Check if current invoice draft is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() == 0;
    }

    /**
     * Check if current invoice draft has content.
     *
     * @return bool
     */
    public function hasContent()
    {
        return !$this->isEmpty();
    }
}
