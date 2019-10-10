@extends('layouts.app')

@section('title', trans('project.payments') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb', ['title' => trans('project.payments')])

<h1 class="page-header">
    <div class="pull-right">
        {!! html_link_to_route('payments.create', trans('payment.create'), ['project_id' => $project, 'customer_id' => $project->customer_id], ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
        {!! html_link_to_route('projects.fees.create', trans('payment.create_fee'), $project, ['class' => 'btn btn-default', 'icon' => 'plus']) !!}
    </div>
    {{ $project->name }} <small>{{ trans('project.payments') }}</small>
</h1>

@include('projects.partials.nav-tabs')
@include('projects.partials.payment-summary')

<?php $groupedPayments = $project->payments->groupBy('in_out');?>
@foreach ($groupedPayments as $key => $payments)
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $key == 1 ? trans('payment.in') : trans('payment.out') }} ({{ $payments->count() }})</h3>
    </div>
    <table class="table table-condensed">
        <thead>
            <th class="text-center">{{ trans('app.table_no') }}</th>
            <th class="col-xs-1 text-center">{{ trans('app.date') }}</th>
            <th class="col-xs-2 text-right">{{ trans('payment.amount') }}</th>
            <th class="col-xs-3">{{ $key == 1 ? trans('app.from') : trans('app.to') }}</th>
            <th class="col-xs-5">{{ trans('payment.description') }}</th>
            <th class="col-xs-1 text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($payments as $key => $payment)
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td class="text-center">{{ $payment->date }}</td>
                <td class="text-right">{{ format_money($payment->amount) }}</td>
                <td>{{ $payment->partner->name }}</td>
                <td>{{ $payment->description }} [{{ $payment->type() }}]</td>
                <td class="text-center">
                    {!! html_link_to_route('payments.show', '',[$payment->id],['class' => 'btn btn-info btn-xs', 'icon' => 'search', 'title' => trans('payment.show')]) !!}
                    @if ($payment->in_out == 1)
                    {!! html_link_to_route('payments.pdf', '',[$payment->id],['class' => 'btn btn-success btn-xs', 'icon' => 'print', 'title' => trans('payment.print')]) !!}
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6">{{ trans('payment.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">{{ trans('app.total') }}</th>
                <th class="text-right">{{ format_money($payments->sum('amount')) }}</th>
                <th colspan="5"></th>
            </tr>
        </tfoot>
    </table>
</div>
@endforeach
@endsection