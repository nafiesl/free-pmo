@extends('layouts.app')

@section('title', trans('payment.show'))

@section('content')
@include('payments.partials.breadcrumb')
<h1 class="page-header">{{ trans('payment.show') }}</h1>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('payment.show') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th>{{ trans('payment.date') }}</th><td>{{ $payment->date }}</td></tr>
                    <tr><th>{{ trans('payment.amount') }}</th><td class="text-right">{{ $payment->present()->amount }}</td></tr>
                    <tr><th>{{ trans('payment.description') }}</th><td>{{ $payment->description }}</td></tr>
                    <tr><th>{{ trans('payment.customer') }}</th><td>{{ $payment->customer->name }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {!! link_to_route('payments.edit', trans('payment.edit'), [$payment->id], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('payments.index', trans('payment.back_to_index'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
</div>
@endsection