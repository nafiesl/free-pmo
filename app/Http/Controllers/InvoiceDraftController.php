<?php

namespace App\Http\Controllers;

use App\Entities\Projects\Project;
use App\Services\InvoiceDrafts\InvoiceDraft;
use App\Services\InvoiceDrafts\InvoiceDraftCollection;
use App\Services\InvoiceDrafts\Item;
use Illuminate\Http\Request;

class InvoiceDraftController extends Controller
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

        return view('invoices.create', compact('draft', 'projects'));
    }

    public function show(Request $request, $draftKey = null)
    {
        $draft = $draftKey ? $this->draftCollection->get($draftKey) : $this->draftCollection->content()->first();
        if (is_null($draft)) {
            flash(trans('invoice.draft_not_found'), 'danger');

            return redirect()->route('invoices.create');
        }

        $projects = Project::pluck('name', 'id');
        return view('invoices.create', compact('draft', 'projects'));
    }

    public function add(Request $request)
    {
        $this->draftCollection->add(new InvoiceDraft());

        return redirect()->route('invoices.create', $this->draftCollection->content()->last()->draftKey);
    }

    public function addDraftItem(Request $request, $draftKey)
    {
        $item = new Item(['description' => $request->description, 'amount' => $request->amount]);
        $this->draftCollection->addItemToDraft($draftKey, $item);

        flash(trans('invoice.item_added'));

        return back();
    }

    public function updateDraftItem(Request $request, $draftKey)
    {
        $this->draftCollection->updateDraftItem($draftKey, $request->item_key, $request->only('description', 'amount'));

        return back();
    }

    public function removeDraftItem(Request $request, $draftKey)
    {
        $this->draftCollection->removeItemFromDraft($draftKey, $request->item_index);

        return back();
    }

    public function empty($draftKey)
    {
        $this->draftCollection->emptyDraft($draftKey);

        return redirect()->route('invoices.create', $draftKey);
    }

    public function remove(Request $request)
    {
        $this->draftCollection->removeDraft($request->draft_key);

        if ($this->draftCollection->isEmpty()) {
            return redirect()->route('invoices.create-empty');
        }

        $lastDraft = $this->draftCollection->content()->last();

        return redirect()->route('invoices.create', $lastDraft->draftKey);
    }

    public function destroy()
    {
        $this->draftCollection->destroy();
        flash(trans('invoice.draft_destroyed'), 'warning');

        return redirect()->route('cart.index');
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

            return redirect()->route('invoices.create', [$draftKey]);
        }

        flash(trans('invoice.confirm_instruction', ['back_link' => link_to_route('invoices.create', trans('app.back'), $draftKey)]), 'warning')->important();

        return redirect()->route('invoices.create', [$draftKey, 'action' => 'confirm']);
    }

    public function store(Request $request, $draftKey)
    {
        $draft = $this->draftCollection->get($draftKey);
        if (is_null($draft)) {
            return redirect()->route('cart.index');
        }

        $invoice = $draft->store();
        $draft->destroy();
        flash(trans('invoice.created', ['invoice_no' => $invoice->invoice_no]), 'success')->important();

        return redirect()->route('invoices.show', $invoice->invoice_no);
    }
}
