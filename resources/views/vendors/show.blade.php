@extends('layouts.app')

@section('title', $vendor->name.' - '.__('vendor.detail'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! link_to_route('vendors.index', __('vendor.back_to_index'), [], ['class' => 'btn btn-default']) !!}
    </div>
    {{ $vendor->name }} <small>{{ __('vendor.detail') }}</small>
</h1>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <tbody>
                    <tr><td class="col-xs-3">{{ __('vendor.name') }}</td><td>{{ $vendor->name }}</td></tr>
                    <tr><td>{{ __('vendor.website') }}</td><td>{{ $vendor->website }}</td></tr>
                    <tr><td>{{ __('app.status') }}</td><td>{{ $vendor->status }}</td></tr>
                    <tr><td>{{ __('app.notes') }}</td><td>{!! nl2br($vendor->notes) !!}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('payment.payments') }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th class="text-center">{{ __('app.table_no') }}</th>
                    <th class="">{{ __('payment.project') }}</th>
                    <th class="text-center ">{{ __('app.date') }}</th>
                    <th class="text-right ">{{ __('payment.amount') }}</th>
                    <th class="col-md-7">{{ __('payment.description') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendor->payments as $key => $payment)
                    <tr>
                        <td class="text-center">{{ 1 + $key }}</td>
                        <td>{{ $payment->project->name }}</td>
                        <td class="text-center">{{ $payment->date }}</td>
                        <td class="text-right">{{ format_money($payment->amount) }}</td>
                        <td>{{ $payment->description }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                    <th class="text-right">{{ format_money($vendor->payments->sum('amount')) }}</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
