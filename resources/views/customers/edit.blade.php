@extends('layouts.app')

@section('title', trans('customer.edit').' '.$customer->name)

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route('customers.show', trans('customer.back_to_show'), [$customer->id], ['class' => 'btn btn-default']) }}
    </div>
    {{ $customer->name }} <small>{{ trans('customer.edit') }}</small>
</h1>

@includeWhen(Request::has('action'), 'customers.forms')

{!! Form::model($customer, ['route' => ['customers.update', $customer->id],'method' => 'patch']) !!}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <legend>@lang('customer.detail')</legend>
                        {!! FormField::text('name', ['required' => true]) !!}
                        <div class="row">
                            <div class="col-xs-6">{!! FormField::radios('is_active', ['Non Aktif', 'Aktif']) !!}</div>
                        </div>
                        {!! FormField::textarea('notes') !!}
                    </div>
                    <div class="col-md-6">
                        <legend>@lang('customer.contact')</legend>
                        {!! FormField::text('pic') !!}
                        <div class="row">
                            <div class="col-xs-7">{!! FormField::email('email') !!}</div>
                            <div class="col-xs-5">{!! FormField::text('phone') !!}</div>
                        </div>
                        {!! FormField::textarea('address') !!}
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('customer.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('customers.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
                {!! link_to_route('customers.edit', trans('app.delete'), [$customer->id, 'action' => 'delete'], [
                    'id' => 'del-customer-'.$customer->id,
                    'class' => 'btn btn-link pull-right'
                ] ) !!}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
