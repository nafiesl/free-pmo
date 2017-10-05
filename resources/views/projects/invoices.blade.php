@extends('layouts.app')

@section('title', trans('project.invoices') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb', ['title' => trans('project.invoices')])

<h1 class="page-header">
    <div class="pull-right">
        {!! html_link_to_route('invoices.create', trans('invoice.create'), ['project_id' => $project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
    </div>
    {{ $project->name }} <small>{{ trans('project.invoices') }}</small>
</h1>

@include('projects.partials.nav-tabs')

<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('project.invoices') }}</h3></div>
            <table class="table table-condensed">
                <thead>
                    <th>{{ trans('app.table_no') }}</th>
                    <th class="col-md-2 text-center">{{ trans('invoice.number') }}</th>
                    <th class="col-md-2 text-center">{{ trans('app.date') }}</th>
                    <th class="col-md-2">{{ trans('invoice.customer') }}</th>
                    <th class="col-md-2 text-right">{{ trans('invoice.amount') }}</th>
                    <th>{{ trans('app.action') }}</th>
                </thead>
                <tbody>
                    @forelse($project->invoices as $key => $invoice)
                    <tr>
                        <td>{{ 1 + $key }}</td>
                        <td class="text-center">{{ $invoice->number }}</td>
                        <td class="text-center">{{ $invoice->created_at->format('Y-m-d') }}</td>
                        <td>{{ $project->customer->name }}</td>
                        <td class="text-right">{{ formatRp($invoice->amount) }}</td>
                        <td>
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
                        <th colspan="4" class="text-right">{{ trans('app.total') }}</th>
                        <th class="text-right">{{ formatRp($project->invoices->sum('amount')) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection