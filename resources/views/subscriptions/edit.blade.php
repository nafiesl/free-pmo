@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
@include('subscriptions.partials.breadcrumb', ['title' => $pageTitle])

@includeWhen(request('action') == 'delete', 'subscriptions.partials.delete')

@if (request('action') == null)
<div class="row">
    <div class="col-md-6">
        {!! Form::model($subscription, ['route'=>['subscriptions.update', $subscription->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $pageTitle }}</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">{!! FormField::radios('type_id', $subscriptionTypes, ['label' => trans('subscription.type'), 'value' => Request::get('type_id')]) !!}</div>
                    <div class="col-md-6">{!! FormField::radios('status_id', [trans('app.in_active'), trans('app.active')],['label' => trans('app.status')]) !!}</div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::text('name',['label' => trans('subscription.name')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::price('price',['label' => trans('subscription.price')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! FormField::text('start_date',['label' => trans('subscription.start_date')]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! FormField::text('due_date',['label' => trans('subscription.due_date')]) !!}
                    </div>
                </div>
                {!! FormField::select('project_id', $projects,['label' => trans('subscription.project')]) !!}
                {!! FormField::select('vendor_id', $vendors,['label' => trans('subscription.vendor')]) !!}
                {!! FormField::textarea('notes',['label' => trans('subscription.notes')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('subscription.update'), ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-3 text-center">
        <legend>@lang('app.action')</legend>
        <p>{!! link_to_route('subscriptions.show', trans('subscription.back_to_show'), [$subscription->id], ['class' => 'btn btn-info']) !!}</p>
        <p>{!! link_to_route('subscriptions.index', trans('subscription.back_to_index'), [], ['class' => 'btn btn-default']) !!}</p>
        <p>{!! link_to_route('subscriptions.edit', trans('subscription.delete'), [$subscription->id, 'action' => 'delete'], ['class'=>'btn btn-danger']) !!}</p>
    </div>
</div>
@endif
@endsection
