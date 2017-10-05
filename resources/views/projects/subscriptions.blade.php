@extends('layouts.app')

@section('title', trans('project.subscriptions'))

@section('content')

@include('projects.partials.breadcrumb',['title' => trans('project.subscriptions')])

<h1 class="page-header">
    <div class="pull-right">
        {!! link_to_route('subscriptions.create', trans('subscription.create'), ['project_id' => $project->id, 'customer_id' => $project->customer_id], ['class'=>'btn btn-success']) !!}
    </div>
    {{ $project->name }} <small>{{ trans('project.subscriptions') }}</small>
</h1>

@include('projects.partials.nav-tabs')

<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('subscription.domain_name') }}</th>
        <th class="text-center">{{ trans('subscription.hosting_capacity') }}</th>
        <th>{{ trans('subscription.start_date') }}</th>
        <th>{{ trans('subscription.due_date') }}</th>
        <th class="text-right">{{ trans('subscription.extension_price') }}</th>
        <th>{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @foreach($project->subscriptions as $key => $subscription)
        <tr {{ Carbon::parse($subscription->due_date)->diffInDays(Carbon::now()) < 60 ? 'class=bg-danger' : '' }}>
            <td>{{ 1 + $key }}</td>
            <td>{{ $subscription->domain_name }}</td>
            <td class="text-center">{{ $subscription->hosting_capacity }}</td>
            <td>{{ dateId($subscription->start_date) }}</td>
            <td>{{ dateId($subscription->due_date) }}</td>
            <td class="text-right">{{ formatRp($subscription->domain_price + $subscription->hosting_price) }}</td>
            <td>
                {!! link_to_route('subscriptions.show',trans('app.show'),[$subscription->id],['class'=>'btn btn-info btn-xs']) !!}
                {!! link_to_route('subscriptions.edit',trans('app.edit'),[$subscription->id],['class'=>'btn btn-warning btn-xs']) !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
