<?php

namespace App\Entities\Invoices;

use App\Entities\BaseRepository;

class InvoicesRepository extends BaseRepository
{
    protected $model;

    public function __construct(Invoice $model)
    {
        parent::__construct($model);
    }

    public function getInvoices($queryStrings)
    {
        return $this->model->orderBy('date', 'desc')
            ->whereHas('project', function ($query) use ($queryStrings) {
                if (isset($queryStrings['q'])) {
                    $query->where('name', 'like', '%'.$queryStrings['q'].'%');
                }
            })
            ->where(function ($query) use ($queryStrings) {
                if (isset($queryStrings['project_id'])) {
                    $query->where('project_id', $queryStrings['project_id']);
                }
            })
            ->with('project.customer')
            ->paginate($this->_paginate);
    }

    public function createInvoice($invoiceData)
    {
        $invoice = new Invoice();
        $invoice->number = $invoice->generateNewNumber();
        $invoice->items = $invoiceData['items'];
        $invoice->project_id = $invoiceData['project_id'];
        $invoice->date = $invoiceData['date'];
        $invoice->due_date = $invoiceData['due_date'] ?? null;
        $invoice->amount = (int) collect($invoiceData['items'])->sum('amount') - ($invoiceData['discount'] ?? 0);
        $invoice->discount = $invoiceData['discount'] ?? null;
        $invoice->discount_notes = $invoiceData['discount_notes'] ?? null;
        $invoice->notes = $invoiceData['notes'] ?? null;
        $invoice->status_id = 1;
        $invoice->creator_id = auth()->id() ?: 1;

        $invoice->save();

        return $invoice;
    }

    public function updateInvoice(Invoice $invoice, $invoiceData)
    {
        $invoice->items = $invoiceData['items'];
        $invoice->project_id = $invoiceData['project_id'];
        $invoice->date = $invoiceData['date'];
        $invoice->due_date = $invoiceData['due_date'] ?? null;
        $invoice->amount = (int) collect($invoiceData['items'])->sum('amount') - ($invoiceData['discount'] ?? 0);
        $invoice->discount = $invoiceData['discount'] ?? null;
        $invoice->discount_notes = $invoiceData['discount_notes'] ?? null;
        $invoice->notes = $invoiceData['notes'] ?? null;

        $invoice->save();

        return $invoice;
    }
}
