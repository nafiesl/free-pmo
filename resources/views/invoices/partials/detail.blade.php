<table class="table">
    <tbody>
        <tr><th class="col-md-4">{{ __('invoice.number') }}</th><td class="text-primary strong">{{ $invoice->number }}</td></tr>
        <tr><th>{{ __('invoice.date') }}</th><td>{{ $invoice->date }}</td></tr>
        <tr><th>{{ __('invoice.due_date') }}</th><td>{{ $invoice->due_date }}</td></tr>
        <tr><th>{{ __('invoice.project') }}</th><td>{{ $invoice->project->nameLink() }}</td></tr>
        <tr><th>{{ __('invoice.customer') }}</th><td>{{ $invoice->project->customer->nameLink() }}</td></tr>
        <tr><th>{{ __('invoice.items_count') }}</th><td>{{ $invoice->items_count }}</td></tr>
        <tr><th>{{ __('invoice.creator') }}</th><td>{{ $invoice->creator->name }}</td></tr>
        <tr><th>{{ __('invoice.amount') }}</th><td class="text-right lead">{{ format_money($invoice->amount) }}</td></tr>
        <tr><th>{{ __('invoice.notes') }}</th><td>{{ $invoice->notes }}</td></tr>
    </tbody>
</table>
