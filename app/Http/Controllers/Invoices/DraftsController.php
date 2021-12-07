<?php

namespace App\Http\Controllers\Invoices;

use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;
use App\Services\InvoiceDrafts\InvoiceDraft;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use App\Services\InvoiceDrafts\Item;
use Illuminate\Http\Request;

/**
 * Invoice Drafts Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class DraftsController extends Controller
{
    private $draftCollection;

    public function __construct()
    {
        $this->draftCollection = new InvoiceDraftCollection();
    }

    public function index(Request $request)
    {
        $draft = $this->draftCollection->content()->first();
        $projects = Project::pluck('name', 'id');

        return view('invoice-drafts.index', compact('draft', 'projects'));
    }

    public function show(Request $request, $draftKey = null)
    {
        $draft = $draftKey ? $this->draftCollection->get($draftKey) : $this->draftCollection->content()->first();
        if (is_null($draft)) {
            flash(__('invoice.draft_not_found'), 'danger');

            return redirect()->route('invoice-drafts.index');
        }

        $projects = Project::pluck('name', 'id');

        return view('invoice-drafts.index', compact('draft', 'projects'));
    }

    public function create(Request $request)
    {
        $draft = new InvoiceDraft();

        if ($request->has('project_id')) {
            $draft->projectId = $request->get('project_id');
        }

        $this->draftCollection->add($draft);

        return redirect()->route('invoice-drafts.show', $this->draftCollection->content()->last()->draftKey);
    }

    public function addDraftItem(Request $request, $draftKey)
    {
        $itemData = $request->validate([
            'new_item_description' => 'required|string|max:255',
            'new_item_amount' => 'required|numeric',
        ]);

        $item = new Item(['description' => $itemData['new_item_description'], 'amount' => $itemData['new_item_amount']]);
        $this->draftCollection->addItemToDraft($draftKey, $item);

        flash(__('invoice.item_added'));

        return back();
    }

    public function updateDraftItem(Request $request, $draftKey)
    {
        $itemData = $request->validate([
            'item_key.*' => 'required|numeric',
            'description.*' => 'required|string|max:255',
            'amount.*' => 'required|numeric',
        ]);

        $itemData = [
            'item_key' => array_shift($itemData['item_key']),
            'description' => array_shift($itemData['description']),
            'amount' => array_shift($itemData['amount']),
        ];

        $this->draftCollection->updateDraftItem($draftKey, $itemData['item_key'], $itemData);

        flash(__('invoice.item_updated'), 'success');

        return back();
    }

    public function removeDraftItem(Request $request, $draftKey)
    {
        $this->draftCollection->removeItemFromDraft($draftKey, $request->item_index);

        flash(__('invoice.item_removed'), 'warning');

        return back();
    }

    public function emptyDraft($draftKey)
    {
        $this->draftCollection->emptyDraft($draftKey);

        return redirect()->route('invoice-drafts.show', $draftKey);
    }

    public function remove(Request $request, $draftKey)
    {
        $this->draftCollection->removeDraft($request->draft_key);

        if ($this->draftCollection->isEmpty()) {
            return redirect()->route('invoice-drafts.index');
        }

        $lastDraft = $this->draftCollection->content()->last();

        return redirect()->route('invoice-drafts.show', $lastDraft->draftKey);
    }

    public function destroy()
    {
        $this->draftCollection->destroy();
        flash(__('invoice.draft_destroyed'), 'warning');

        return redirect()->route('invoice-drafts.index');
    }

    public function proccess($draftKey)
    {
        $invoiceData = request()->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string|max:100',
            'due_date' => 'nullable|date|after:date',
            'project_id' => 'required|exists:projects,id',
        ]);

        $draft = $this->draftCollection->updateDraftAttributes($draftKey, $invoiceData);

        if ($draft->getItemsCount() == 0) {
            flash(__('invoice.item_list_empty'), 'warning');

            return redirect()->route('invoice-drafts.show', [$draftKey]);
        }

        return redirect()->route('invoice-drafts.show', [$draftKey, 'action' => 'confirm']);
    }

    public function store(Request $request, $draftKey)
    {
        $draft = $this->draftCollection->get($draftKey);
        if (is_null($draft)) {
            return redirect()->route('invoice-drafts.index');
        }

        $invoice = $draft->store();
        $draft->destroy();
        flash(__('invoice.created', ['number' => $invoice->number]), 'success');

        return redirect()->route('invoices.show', $invoice->number);
    }
}
