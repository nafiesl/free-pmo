@extends('layouts.app')

@section('title', trans('subscription.subscriptions'))

@section('content')
<h1 class="page-header">
    {!! link_to_route('subscriptions.create', trans('subscription.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    {{ trans('subscription.subscriptions') }} <small>{{ $subscriptions->total() }} {{ trans('subscription.found') }}</small>
</h1>
<div class="well well-sm">
    {!! Form::open(['method'=>'get','class'=>'form-inline']) !!}
    {!! Form::text('q', request('q'), ['class'=>'form-control index-search-field','placeholder'=>trans('subscription.search'),'style' => 'width:350px']) !!}
    {!! Form::submit(trans('subscription.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {!! link_to_route('subscriptions.index','Reset',[],['class' => 'btn btn-default btn-sm']) !!}
    {!! Form::close() !!}
</div>

<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('subscription.name') }}</th>
        <th class="text-center">{{ trans('app.type') }}</th>
        <th>{{ trans('subscription.customer') }}</th>
        <th class="text-right">{{ trans('subscription.due_date') }}</th>
        <th class="text-right">{{ trans('subscription.extension_price') }}</th>
        <th>{{ trans('subscription.vendor') }}</th>
        <th class="text-center">{{ trans('app.status') }}</th>
    </thead>
    <tbody>
        @forelse($subscriptions as $key => $subscription)
        <tr>
            <td>{{ $subscriptions->firstItem() + $key }}</td>
            <td>{{ $subscription->nameLink() }}</td>
            <td class="text-center">
                <span class="badge" style="background-color: {{ $subscription->type_color }};">
                    {{ $subscription->type }}
                </span>
            </td>
            <td>{{ $subscription->customer->name }}</td>
            <td class="text-right" title="{!! $subscription->dueDateDescription() !!}">
                {{ dateId($subscription->due_date) }} {!! $subscription->nearOfDueDateSign() !!}
            </td>
            <td class="text-right">{{ formatRp($subscription->price) }}</td>
            <td>{{ $subscription->vendor->name }}</td>
            <td class="text-center">{{ $subscription->status() }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7">{{ trans('subscription.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $subscriptions->appends(Request::except('page'))->render()) !!}
@endsection
