<?php

namespace App\Http\Controllers\Invoices;

use App\Entities\Invoices\Invoice;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    public function store(Invoice $invoice)
    {
        $itemData = request()->validate([
            'new_item_description' => 'required|string|max:255',
            'new_item_amount'      => 'required|numeric',
        ]);

        $items = $invoice->items;
        $items[] = [
            'description' => $itemData['new_item_description'],
            'amount'      => $itemData['new_item_amount'],
        ];
        $invoice->items = $items;
        $invoice->amount = (int) collect($items)->sum('amount') - $invoice->discount;
        $invoice->save();

        flash(__('invoice.item_added'));

        return back();
    }

    public function update(Invoice $invoice)
    {
        $rawItemData = request()->validate([
            'item_key.*'    => 'required|numeric',
            'description.*' => 'required|string|max:255',
            'amount.*'      => 'required|numeric',
        ]);

        $itemKey = array_shift($rawItemData['item_key']);
        $amount = array_shift($rawItemData['amount']);
        $description = array_shift($rawItemData['description']);

        $items = $invoice->items;
        $items[$itemKey] = [
            'description' => $description,
            'amount'      => $amount,
        ];
        $invoice->items = $items;
        $invoice->amount = (int) collect($items)->sum('amount') - $invoice->discount;
        $invoice->save();

        flash(__('invoice.item_updated'));

        return back();
    }

    public function destroy(Invoice $invoice)
    {
        $itemData = request()->validate([
            'item_index' => 'required|numeric',
        ]);

        $itemIndex = $itemData['item_index'];

        $items = $invoice->items;
        unset($items[$itemIndex]);
        $invoice->items = $items;
        $invoice->amount = (int) collect($items)->sum('amount') - $invoice->discount;
        $invoice->save();

        flash(__('invoice.item_removed'));

        return back();
    }
}
