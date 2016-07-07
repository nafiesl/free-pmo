@extends('layouts.app')

@section('title', trans('project.payments'))

@section('content')
@include('projects.partials.breadcrumb',['title' => trans('project.payments')])

<h1 class="page-header">{{ $project->name }} <small>{{ trans('project.payments') }}</small></h1>

@include('projects.partials.nav-tabs')

<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th class="text-center">{{ trans('payment.date') }}</th>
            <th class="text-right">{{ trans('payment.amount') }}</th>
            <th>{{ trans('payment.description') }}</th>
            <th>{{ trans('payment.customer') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            @forelse($project->payments as $key => $payment)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td class="text-center">{{ $payment->date }}</td>
                <td class="text-right">{{ $payment->present()->amount }}</td>
                <td>{{ $payment->description }}</td>
                <td>{{ $payment->customer->name }}</td>
                <td>{!! html_link_to_route('payments.show',trans('app.show'),[$payment->id],['class' => 'btn btn-info btn-xs']) !!}</td>
            </tr>
            <?php $total = $payment->type == 0 ? $total - $payment->amount : $total + $payment->amount ?>
            @empty
            <tr><td colspan="6">{{ trans('payment.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">{{ trans('app.total') }}</th>
                <th class="text-right">{{ formatRp($total) }}</th>
                <th colspan="5"></th>
            </tr>
            <tr><td colspan="6">{!! html_link_to_route('payments.create', trans('payment.create'), [$project->id], ['class' => 'btn btn-primary','icon' => 'plus']) !!}</td></tr>
        </tfoot>
    </table>
</div>
@endsection