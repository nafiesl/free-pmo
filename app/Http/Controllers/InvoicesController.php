<?php

namespace App\Http\Controllers;

use App\Entities\Invoices\Invoice;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }
}
