@extends('layouts.app')

@section('title', __('invoice.list'))

@section('content')

<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::formButton(['route' => 'invoice-drafts.create'], __('invoice.create'), [
            'class' => 'btn btn-success',
            'name' => 'create-invoice-draft',
            'id' => 'invoice-draft-create-button'
        ]) !!}
    </div>
    {{ __('invoice.list') }}
</h1>

<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th class="text-center">{{ __('app.table_no') }}</th>
            <th class="col-md-1 text-center">{{ __('invoice.number') }}</th>
            <th class="col-md-1 text-center">{{ __('app.date') }}</th>
            <th class="col-md-3">{{ __('project.project') }}</th>
            <th class="col-md-3">{{ __('invoice.customer') }}</th>
            <th class="col-md-2 text-right">{{ __('invoice.amount') }}</th>
            <th class="col-md-2 text-center">{{ __('app.action') }}</th>
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
                            'title' => __('invoice.print'), 'target' => '_blank'
                        ]
                    ) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ __('invoice.empty') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $invoices->appends(Request::except('page'))->render() }}
@endsection
