@extends('layouts.app')

@section('title', trans('payment.detail'))

@section('content')

@include('payments.partials.breadcrumb')

<div class="row">
    <div class="col-md-5 col-lg-offset-2">
        <legend>@lang('payment.detail') <small class="pull-right text-muted">{{ trans('app.type') }} : {{ $payment->type() }}</small></legend>
        @include('payments.partials.payment-show')
    </div>
    <div class="col-md-3 text-center">
        <legend>@lang('app.action')</legend>
        <p>{!! link_to_route('payments.pdf', trans('payment.print'), [$payment->id], ['class' => 'btn btn-success']) !!}</p>
        <p>{!! link_to_route('payments.edit', trans('payment.edit'), [$payment->id], ['class' => 'btn btn-warning']) !!}</p>
        <p>{!! link_to_route('projects.payments', __('project.view_payments'), [$payment->project_id], ['class' => 'btn btn-default']) !!}</p>
        <p>{!! link_to_route('payments.index', __('payment.back_to_index'), [], ['class' => 'btn btn-default']) !!}</p>
    </div>
</div>
@endsection
