@extends('layouts.app')

@section('title', __('subscription.subscriptions'))

@section('content')
<h1 class="page-header">
    {!! link_to_route('subscriptions.create', __('subscription.create'), [], ['class' => 'btn btn-success pull-right']) !!}
    {{ __('subscription.subscriptions') }} <small>{{ $subscriptions->total() }} {{ __('subscription.found') }}</small>
</h1>
<div class="well well-sm">
    {!! Form::open(['method' => 'get', 'class' => 'form-inline']) !!}
    {!! Form::text('q', request('q'), ['class' => 'form-control index-search-field', 'placeholder' =>__('subscription.search'), 'style' => 'width:350px']) !!}
    {!! Form::submit(__('subscription.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {!! link_to_route('subscriptions.index', __('app.reset'), [], ['class' => 'btn btn-default btn-sm']) !!}
    {!! Form::close() !!}
</div>

<table class="table table-condensed">
    <thead>
        <th>{{ __('app.table_no') }}</th>
        <th>{{ __('subscription.name') }}</th>
        <th class="text-center">{{ __('app.type') }}</th>
        <th>{{ __('subscription.customer') }}</th>
        <th class="text-right">{{ __('subscription.due_date') }}</th>
        <th class="text-right">{{ __('subscription.extension_price') }}</th>
        <th>{{ __('subscription.vendor') }}</th>
        <th class="text-center">{{ __('app.status') }}</th>
    </thead>
    <tbody>
        @forelse($subscriptions as $key => $subscription)
        <tr>
            <td>{{ $subscriptions->firstItem() + $key }}</td>
            <td>{{ $subscription->name_link }}</td>
            <td class="text-center">{!! $subscription->type_label !!}</td>
            <td>{{ $subscription->customer->name }}</td>
            <td class="text-right" title="{!! $subscription->dueDateDescription() !!}">
                {{ date_id($subscription->due_date) }} {!! $subscription->nearOfDueDateSign() !!}
            </td>
            <td class="text-right">{{ format_money($subscription->price) }}</td>
            <td>{{ $subscription->vendor->name }}</td>
            <td class="text-center">{{ $subscription->status() }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7">{{ __('subscription.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $subscriptions->appends(Request::except('page'))->render()) !!}
@endsection
