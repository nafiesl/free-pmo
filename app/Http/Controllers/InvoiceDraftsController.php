<?php

namespace App\Http\Controllers;

use App\Entities\Projects\Project;
use App\Services\InvoiceDrafts\InvoiceDraft;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use App\Services\InvoiceDrafts\Item;
use Illuminate\Http\Request;

/**
 * Invoice Drafts Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoiceDraftsController extends Controller
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
            flash(trans('invoice.draft_not_found'), 'danger');

            return redirect()->route('invoice-drafts.index');
        }

        $projects = Project::pluck('name', 'id');
        return view('invoice-drafts.index', compact('draft', 'projects'));
    }

    public function create(Request $request)
    {
        $this->draftCollection->add(new InvoiceDraft());

        return redirect()->route('invoice-drafts.show', $this->draftCollection->content()->last()->draftKey);
    }

    public function addDraftItem(Request $request, $draftKey)
    {
        $itemData = $request->validate([
            'new_item_description' => 'required|string|max:255',
            'new_item_amount'      => 'required|numeric',
        ]);

        $item = new Item(['description' => $itemData['new_item_description'], 'amount' => $itemData['new_item_amount']]);
        $this->draftCollection->addItemToDraft($draftKey, $item);

        flash(trans('invoice.item_added'));

        return back();
    }

    public function updateDraftItem(Request $request, $draftKey)
    {
        $itemData = $request->validate([
            'item_key.*'    => 'required|numeric',
            'description.*' => 'required|string|max:255',
            'amount.*'      => 'required|numeric',
        ]);

        $itemData = [
            'item_key'    => array_shift($itemData['item_key']),
            'description' => array_shift($itemData['description']),
            'amount'      => array_shift($itemData['amount']),
        ];

        $this->draftCollection->updateDraftItem($draftKey, $itemData['item_key'], $itemData);

        return back();
    }

    public function removeDraftItem(Request $request, $draftKey)
    {
        $this->draftCollection->removeItemFromDraft($draftKey, $request->item_index);

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
        flash(trans('invoice.draft_destroyed'), 'warning');

        return redirect()->route('invoice-drafts.index');
    }

    public function proccess(Request $request, $draftKey)
    {
        $this->validate($request, [
            'project_id' => 'required|exists:projects,id',
            'notes'      => 'nullable|string|max:100',
        ]);

        $draft = $this->draftCollection->updateDraftAttributes($draftKey, $request->only('project_id', 'notes'));

        if ($draft->getItemsCount() == 0) {
            flash(trans('invoice.item_list_empty'), 'warning')->important();

            return redirect()->route('invoice-drafts.show', [$draftKey]);
        }

        flash(trans('invoice.confirm_instruction'), 'warning')->important();

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
        flash(trans('invoice.created', ['number' => $invoice->number]), 'success')->important();

        return redirect()->route('invoices.show', $invoice->number);
    }
}
