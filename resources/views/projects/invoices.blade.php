@extends('layouts.app')

@section('title', trans('project.invoices') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb', ['title' => trans('project.invoices')])

<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::formButton(['route' => 'invoice-drafts.store'], trans('invoice.create'), [
            'class' => 'btn btn-default',
            'name' => 'create-invoice-draft',
            'id' => 'invoice-draft-create-button'
        ] ) !!}
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
            <th class="col-md-2 text-center">{{ trans('app.date') }}</th>
            <th class="col-md-2">{{ trans('invoice.customer') }}</th>
            <th class="col-md-2">{{ trans('app.description') }}</th>
            <th class="col-md-2 text-right">{{ trans('invoice.amount') }}</th>
            <th class="col-md-2 text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($project->invoices as $key => $invoice)
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td class="text-center">{{ $invoice->number }}</td>
                <td class="text-center">{{ $invoice->created_at->format('Y-m-d') }}</td>
                <td>{{ $project->customer->name }}</td>
                <td>{!! nl2br($invoice->description) !!}</td>
                <td class="text-right">{{ formatRp($invoice->amount) }}</td>
                <td class="text-center">
                    {!! html_link_to_route('invoices.show', '', [$invoice->number], ['class' => 'btn btn-info btn-xs','icon' => 'search','title' => 'Lihat ' . trans('invoice.show')]) !!}
                    {!! html_link_to_route('invoices.pdf', '', [$invoice->number], ['class' => 'btn btn-default btn-xs','icon' => 'print','title' => trans('invoice.print'), 'target' => '_blank']) !!}
                </td>
            </tr>
            @empty
            <tr><td colspan="6">{{ trans('invoice.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">{{ trans('app.total') }}</th>
                <th class="text-right">{{ formatRp($project->invoices->sum('amount')) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
