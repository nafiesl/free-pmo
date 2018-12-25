@extends('layouts.customer')

@section('title', trans('customer.invoices'))

@section('content-customer')
<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th class="text-center">{{ trans('app.table_no') }}</th>
            <th class="col-md-2 text-center">{{ trans('invoice.number') }}</th>
            <th class="col-md-2 text-center">{{ trans('app.date') }}</th>
            <th class="col-md-2">{{ trans('project.project') }}</th>
            <th class="col-md-2">{{ trans('invoice.customer') }}</th>
            <th class="col-md-2 text-right">{{ trans('invoice.amount') }}</th>
            <th class="col-md-2 text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($invoices as $key => $invoice)
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td class="text-center">{{ $invoice->numberLink() }}</td>
                <td class="text-center">{{ $invoice->created_at->format('Y-m-d') }}</td>
                <td>{{ $invoice->project->nameLink() }}</td>
                <td>{{ $invoice->project->customer->nameLink() }}</td>
                <td class="text-right">{{ format_money($invoice->amount) }}</td>
                <td class="text-center">
                    {!! html_link_to_route(
                        'invoices.show', '', [$invoice->number],
                        [
                            'icon' => 'search',
                            'class' => 'btn btn-info btn-xs',
                            'title' =>  __('invoice.show'),
                        ]
                    ) !!}
                    {!! html_link_to_route(
                        'invoices.pdf', '', [$invoice->number],
                        [
                            'icon' => 'print',
                            'class' => 'btn btn-default btn-xs',
                            'title' => trans('invoice.print'), 'target' => '_blank'
                        ]
                    ) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('invoice.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">{{ trans('app.total') }}</th>
                <th class="text-right">{{ format_money($invoices->sum('amount')) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
