<?php

namespace App\Http\Controllers\Invoices;

use App\Entities\Invoices\BankAccount;
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
        $invoices = Invoice::orderBy('date', 'desc')
            ->with('project.customer')
            ->paginate();

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
            'date' => 'required|date',
            'due_date' => 'nullable|date|after:date',
            'discount' => 'nullable|numeric',
            'discount_notes' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);
        $invoiceSubtotal = collect($invoice->items)->sum('amount');
        $invoiceData['amount'] = $invoiceSubtotal - $invoiceData['discount'];

        $invoice->update($invoiceData);

        flash(__('invoice.updated'), 'success');

        return redirect()->route('invoices.show', $invoice);
    }

    public function destroy(Invoice $invoice)
    {
        $this->validate(request(), [
            'invoice_id' => 'required',
        ]);

        if (request('invoice_id') == $invoice->id && $invoice->delete()) {
            flash(__('invoice.deleted'), 'warning');

            return redirect()->route('projects.invoices', $invoice->project_id);
        }

        flash(__('invoice.undeleted'), 'danger');

        return back();
    }

    public function pdf(Invoice $invoice)
    {
        $bankAccounts = BankAccount::where('is_active', 1)->get();

        return view('invoices.pdf', compact('invoice', 'bankAccounts'));
    }
}
