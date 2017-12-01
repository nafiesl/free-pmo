<?php

namespace App\Http\Controllers;

use App\Entities\Invoices\Invoice;

/**
 * Invoices Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoicesController extends Controller
{
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function pdf(Invoice $invoice)
    {
        return view('invoices.pdf', compact('invoice'));
    }
}
