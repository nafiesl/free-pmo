<?php

namespace App\Services\InvoiceDrafts;

use App\Entities\Invoices\Invoice;

/**
 * Invoice Draft.
 */
class InvoiceDraft
{
    public $items = [];

    public $projectId;
    public $notes;

    public function items()
    {
        return collect($this->items)->sortBy('name');
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $item;
    }

    public function removeItem($itemKey)
    {
        unset($this->items[$itemKey]);
    }

    public function empty()
    {
        $this->items = [];
    }

    public function getTotal()
    {
        return $this->items()->sum('amount');
    }

    public function getItemsCount()
    {
        return $this->items()->count();
    }

    public function updateItem($itemKey, $newItemData)
    {
        if (!isset($this->items[$itemKey])) {
            return;
        }

        $item = $this->items[$itemKey];

        $this->items[$itemKey] = $item->updateAttribute($newItemData);

        return $item;
    }

    public function store()
    {
        $invoice = new Invoice();
        $invoice->invoice_no = $this->getNewInvoiceNo();
        $invoice->items = $this->getItemsArray();
        $invoice->project_id = $this->projectId;
        $invoice->amount = $this->getTotal();
        $invoice->notes = $this->notes;
        $invoice->status_id = 1;
        $invoice->user_id = auth()->id() ?: 1;

        $invoice->save();

        return $invoice;
    }

    public function getNewInvoiceNo()
    {
        $prefix = date('ym');

        $lastInvoice = Invoice::orderBy('invoice_no', 'desc')->first();

        if (!is_null($lastInvoice)) {
            $lastInvoiceNo = $lastInvoice->invoice_no;
            if (substr($lastInvoiceNo, 0, 4) == $prefix) {
                return ++$lastInvoiceNo;
            }
        }

        return $prefix.'0001';
    }

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

    public function destroy()
    {
        $cart = app(InvoiceDraftCollection::class);

        return $cart->removeDraft($this->draftKey);
    }
}
