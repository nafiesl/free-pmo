<?php

namespace App\Http\Controllers\Invoices;

use App\Entities\Invoices\Invoice;
use App\Http\Controllers\Controller;
use App\Services\InvoiceDrafts\InvoiceDraft;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use App\Services\InvoiceDrafts\Item;

class DuplicationController extends Controller
{
    private $draftCollection;

    public function __construct()
    {
        $this->draftCollection = new InvoiceDraftCollection();
    }

    public function store(Invoice $invoice)
    {
        $draft = new InvoiceDraft();
        $this->draftCollection->add($draft);

        foreach ($invoice->items as $existingItem) {
            $item = new Item(['description' => $existingItem['description'], 'amount' => $existingItem['amount']]);
            $this->draftCollection->addItemToDraft($draft->draftKey, $item);
        }
        $draft->date = today()->format('Y-m-d');
        $draft->projectId = $invoice->project_id;
        $draft->notes = $invoice->notes;

        return redirect()->route('invoice-drafts.show', $draft->draftKey);
    }
}
