<?php

namespace App\Http\Controllers\Invoices;

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

    public function pdf(Invoice $invoice)
    {
        return view('invoices.pdf', compact('invoice'));
    }
}
