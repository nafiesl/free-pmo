<?php

namespace App\Http\Controllers\Api;

use App\Entities\Invoices\Invoice;
use App\Entities\Invoices\InvoicesRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $repo;

    public function __construct(InvoicesRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $invoices = $this->repo->getInvoices($request->only('q', 'project_id'));

        return response()->json($invoices, 200);
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        return $invoice->load('project.customer', 'creator');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Invoice);

        $invoiceData = $request->validate([
            'project_id' => 'required|numeric|exists:projects,id',
            'date' => 'required|date|date_format:Y-m-d',
            'due_date' => 'nullable|date|date_format:Y-m-d|after:date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.amount' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_notes' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $invoice = $this->repo->createInvoice($invoiceData);

        return response()->json(['message' => __('invoice.created'), 'id' => $invoice->id], 201);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $invoiceData = $request->validate([
            'project_id' => 'required|numeric|exists:projects,id',
            'date' => 'required|date|date_format:Y-m-d',
            'due_date' => 'nullable|date|date_format:Y-m-d|after:date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.amount' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_notes' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $invoice = $this->repo->updateInvoice($invoice, $invoiceData);

        return response()->json(['message' => __('invoice.updated'), 'id' => $invoice->id], 200);
    }

    public function destroy(Invoice $invoice)
    {
        $this->authorize('delete', $invoice);

        $invoice->delete();

        return response()->json(['message' => __('invoice.deleted')], 200);
    }
}
