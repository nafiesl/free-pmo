<?php

namespace App\Services\InvoiceDrafts;

use App\Entities\Invoices\Invoice;

/**
 * Invoice Draft.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoiceDraft
{
    /**
     * Invoice draft items.
     *
     * @var array
     */
    public $items = [];

    /**
     * Invoice data.
     *
     * @var string
     */
    public $date;

    /**
     * Invoice notes.
     *
     * @var string
     */
    public $notes;

    /**
     * Invoice due date.
     *
     * @var string
     */
    public $dueDate;

    /**
     * Invoice project id from database.
     *
     * @var int
     */
    public $projectId;

    /**
     * Get item list sort by iten name.
     *
     * @return \Illuminate\Support\Collection
     */
    public function items()
    {
        return collect($this->items)->sortBy('name');
    }

    /**
     * Add new item to invoice item collection.
     *
     * @param  \App\Services\InvoiceDrafts\Item  $item
     * @return \App\Services\InvoiceDrafts\Item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $item;
    }

    /**
     * Remove item from the collection.
     *
     * @param  int  $itemKey  Key of invoice item.
     * @return void
     */
    public function removeItem($itemKey)
    {
        unset($this->items[$itemKey]);
    }

    /**
     * Empty out invoice draft items.
     *
     * @return void
     */
    public function empty()
    {
        $this->items = [];
    }

    /**
     * Get invoice total amount.
     *
     * @return int Total amount of invoice.
     */
    public function getTotal()
    {
        return $this->items()->sum('amount');
    }

    /**
     * Get invoice items count.
     *
     * @return int Items count of invoice.
     */
    public function getItemsCount()
    {
        return $this->items()->count();
    }

    /**
     * Update an invoice item.
     *
     * @param  int  $itemKey  The item key
     * @param  array  $newItemData  The item attributes.
     * @return null|\App\Services\InvoiceDrafts\Item
     */
    public function updateItem($itemKey, $newItemData)
    {
        if (!isset($this->items[$itemKey])) {
            return;
        }

        $item = $this->items[$itemKey];

        $this->items[$itemKey] = $item->updateAttribute($newItemData);

        return $item;
    }

    /**
     * Store invoice draft to database as invoice record.
     *
     * @return \App\Entities\Invoices\Invoice The saved invoice.
     */
    public function store()
    {
        $invoice = new Invoice();
        $invoice->number = $invoice->generateNewNumber();
        $invoice->items = $this->getItemsArray();
        $invoice->project_id = $this->projectId;
        $invoice->date = $this->date;
        $invoice->due_date = $this->dueDate;
        $invoice->amount = $this->getTotal();
        $invoice->notes = $this->notes;
        $invoice->status_id = 1;
        $invoice->creator_id = auth()->id() ?: 1;

        $invoice->save();

        return $invoice;
    }

    /**
     * Get invoice items in array format.
     *
     * @return array Array of items.
     */
    protected function getItemsArray()
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = [
                'description' => $item->description,
                'amount'      => $item->amount,
            ];
        }

        return $items;
    }

    /**
     * Destroy current invocie draft from the session.
     *
     * @return void
     */
    public function destroy()
    {
        $cart = app(InvoiceDraftCollection::class);

        return $cart->removeDraft($this->draftKey);
    }
}
