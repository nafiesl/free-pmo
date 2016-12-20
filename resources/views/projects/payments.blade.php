@extends('layouts.app')

@section('title', trans('project.payments') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb',['title' => trans('project.payments')])

<h1 class="page-header">
    <div class="pull-right">
        {!! html_link_to_route('payments.create', trans('payment.create'), ['project_id' => $project->id,'customer_id' => $project->customer_id], ['class' => 'btn btn-primary','icon' => 'plus']) !!}
    </div>
    {{ $project->name }} <small>{{ trans('project.payments') }}</small>
</h1>

@include('projects.partials.nav-tabs')

<div class="row">
    <div class="col-md-9">

        <?php $groupedPayments = $project->payments->groupBy('in_out'); ?>
        @foreach ($groupedPayments as $key => $payments)
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $key == 1 ? 'Pemasukan' : 'Pengeluaran' }}</h3></div>
            <table class="table table-condensed">
                <thead>
                    <th>{{ trans('app.table_no') }}</th>
                    <th class="col-md-2 text-center">{{ trans('app.date') }}</th>
                    <th class="col-md-2 text-right">{{ trans('payment.amount') }}</th>
                    <th class="col-md-2">{{ $key == 1 ? 'Dari' : 'Ke' }}</th>
                    <th class="col-md-5">{{ trans('payment.description') }}</th>
                    <th>{{ trans('app.action') }}</th>
                </thead>
                <tbody>
                    @forelse($payments as $key => $payment)
                    <tr>
                        <td>{{ 1 + $key }}</td>
                        <td class="text-center">{{ $payment->date }}</td>
                        <td class="text-right">{{ formatRp($payment->amount) }}</td>
                        <td>{{ $payment->customer->name }}</td>
                        <td>{{ $payment->description }} [{{ $payment->type() }}]</td>
                        <td>{!! html_link_to_route('payments.show','',[$payment->id],['class' => 'btn btn-info btn-xs','icon' => 'search','title' => 'Lihat ' . trans('payment.show')]) !!}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6">{{ trans('payment.empty') }}</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">{{ trans('app.total') }}</th>
                        <th class="text-right">{{ formatRp($payments->sum('amount')) }}</th>
                        <th colspan="5"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endforeach
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Summary</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th>{{ trans('project.project_value') }}</th><td class="text-right">{{ formatRp($project->project_value) }}</td></tr>
                    <tr><th>{{ trans('project.cash_in_total') }}</th><td class="text-right">{{ formatRp($project->cashInTotal()) }}</td></tr>
                    <tr><th>{{ trans('project.cash_out_total') }}</th><td class="text-right">{{ formatRp($project->cashOutTotal()) }}</td></tr>
                    <tr><th>Sisa</th><td class="text-right">{{ formatRp($balance = $project->project_value - $project->cashInTotal()) }}</td></tr>
                    <tr><th>{{ trans('app.status') }}</th><td>{{ $balance > 0 ? 'Belum Lunas' : 'Lunas' }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection