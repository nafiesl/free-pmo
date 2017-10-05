@extends('layouts.app')

@section('title', $invoice->number . ' - ' . trans('invoice.detail'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">{{ link_to_route('invoices.pdf', trans('invoice.print'), [$invoice->number], ['class' => 'btn btn-default']) }}</div>
    {{ $invoice->number }} <small>{{ trans('invoice.detail') }}</small>
</h1>
<div class="row">
    <div class="col-sm-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.detail') }}</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><td>{{ trans('invoice.number') }}</td><td class="text-primary strong">{{ $invoice->number }}</td></tr>
                        <tr><td>{{ trans('app.date') }}</td><td>{{ $invoice->created_at->format('Y-m-d') }}</td></tr>
                        <tr><td>{{ trans('invoice.project') }}</td><td>{{ $invoice->project->name }}</td></tr>
                        <tr><td>{{ trans('invoice.customer') }}</td><td>{{ $invoice->project->customer->name }}</td></tr>
                        <tr><td>{{ trans('invoice.items_count') }}</td><td>{{ $invoice->items_count }}</td></tr>
                        <tr><td>{{ trans('invoice.amount') }}</td><td class="text-right strong">{{ formatRp($invoice->amount) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.items') }}</h3></div>
        <div class="panel-body">
            <table class="table table-condensed">
            <thead>
                <tr>
                    <th>{{ trans('app.table_no') }}</th>
                    <th>{{ trans('invoice.item_description') }}</th>
                    <th class="text-right">{{ trans('invoice.item_amount') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['description'] }}</td>
                    <td class="text-right">{{ formatRp($item['amount']) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-right">{{ trans('app.total') }} :</th>
                    <th class="text-right">{{ formatRp($invoice->amount) }}</th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
    </div>
</div>
@endsection