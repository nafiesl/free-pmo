<?php

namespace App\Http\Controllers\Invoices;

use Option;
use App\Entities\Invoices\Invoice;
use App\Entities\Projects\Project;
use App\Http\Controllers\Controller;

/**
 * Invoices Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoice::paginate();

        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $projects = Project::pluck('name', 'id');

        return view('invoices.edit', compact('invoice', 'projects'));
    }

    public function update(Invoice $invoice)
    {
        $invoiceData = request()->validate([
            'project_id' => 'required|exists:projects,id',
            'date'       => 'required|date',
            'due_date'   => 'nullable|date|after:date',
            'notes'      => 'nullable|string|max:255',
        ]);

        $invoice->update($invoiceData);

        flash(trans('invoice.updated'), 'success');

        return redirect()->route('invoices.show', $invoice);
    }

    public function destroy(Invoice $invoice)
    {
        $this->validate(request(), [
            'invoice_id' => 'required',
        ]);

        if (request('invoice_id') == $invoice->id && $invoice->delete()) {
            flash(trans('invoice.deleted'), 'warning');

            return redirect()->route('projects.invoices', $invoice->project_id);
        }

        flash(trans('invoice.undeleted'), 'danger');

        return back();
    }

    public function pdf(Invoice $invoice)
    {
        $bankAccounts = json_decode(Option::get('bank_accounts'), true) ?: [];

        return view('invoices.pdf', compact('invoice', 'bankAccounts'));
    }
}
