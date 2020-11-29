@extends('layouts.app')

@section('title', __('customer.edit').' '.$customer->name)

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('customers.show', __('customer.back_to_show'), [$customer->id], ['class' => 'btn btn-default']) }}
    </div>
    {{ $customer->name }} <small>{{ __('customer.edit') }}</small>
</h1>

@if (Request::has('action'))
    @include('customers.forms')
@else
{!! Form::model($customer, ['route' => ['customers.update', $customer->id], 'method' => 'patch']) !!}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <legend>{{ __('customer.detail') }}</legend>
                        {!! FormField::text('name', ['required' => true]) !!}
                        <div class="row">
                            <div class="col-xs-6">{!! FormField::radios('is_active', [__('app.in_active'), __('app.active')]) !!}</div>
                        </div>
                        {!! FormField::textarea('notes') !!}
                    </div>
                    <div class="col-md-6">
                        <legend>{{ __('customer.contact') }}</legend>
                        {!! FormField::text('pic') !!}
                        <div class="row">
                            <div class="col-xs-7">{!! FormField::email('email') !!}</div>
                            <div class="col-xs-5">{!! FormField::text('phone') !!}</div>
                        </div>
                        {!! FormField::text('website') !!}
                        {!! FormField::textarea('address') !!}
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('customer.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('customers.index', __('app.cancel'), [], ['class' => 'btn btn-default']) }}
                {!! link_to_route('customers.edit', __('app.delete'), [$customer->id, 'action' => 'delete'], [
                    'id' => 'del-customer-'.$customer->id,
                    'class' => 'btn btn-link pull-right'
                ] ) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endif
@endsection
