@extends('layouts.app')

@section('title', trans('project.invoices') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb', ['title' => trans('project.invoices')])

<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::formButton(['route' => 'invoice-drafts.create'], trans('invoice.create'), [
            'class' => 'btn btn-success',
            'name' => 'create-invoice-draft',
            'id' => 'invoice-draft-create-button'
        ], [
            'project_id' => $project->id
        ]) !!}
    </div>
    {{ $project->name }} <small>{{ trans('project.invoices') }}</small>
</h1>

@include('projects.partials.nav-tabs')

<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('project.invoices') }}</h3></div>
    <table class="table">
        <thead>
            <th class="text-center">{{ trans('app.table_no') }}</th>
            <th class="col-md-2 text-center">{{ trans('invoice.number') }}</th>
            <th class="col-md-2 text-center">{{ trans('invoice.date') }}</th>
            <th class="col-md-2 text-center">{{ trans('invoice.due_date') }}</th>
            <th class="col-md-3">{{ trans('invoice.customer') }}</th>
            <th class="col-md-2 text-right">{{ trans('invoice.amount') }}</th>
            <th class="col-md-1 text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($invoices as $key => $invoice)
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td class="text-center">{{ $invoice->numberLink() }}</td>
                <td class="text-center">{{ $invoice->date }}</td>
                <td class="text-center">{{ $invoice->due_date }}</td>
                <td>{{ $project->customer->nameLink() }}</td>
                <td class="text-right">{{ format_money($invoice->amount) }}</td>
                <td class="text-center">
                    {!! html_link_to_route(
                        'invoices.show', '', [$invoice->number],
                        [
                            'class' => 'btn btn-info btn-xs',
                            'icon' => 'search',
                            'title' =>  __('invoice.show'),
                        ]
                    ) !!}
                    {!! html_link_to_route(
                        'invoices.pdf', '', [$invoice->number],
                        [
                            'class' => 'btn btn-default btn-xs',
                            'icon' => 'print',
                            'title' => __('invoice.print'),
                            'target' => '_blank'
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
                <th class="text-right">{{ format_money($project->invoices->sum('amount')) }}</th>
                <th>&nbsp;</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
