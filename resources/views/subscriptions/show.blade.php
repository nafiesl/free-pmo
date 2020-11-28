@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
@include('subscriptions.partials.breadcrumb')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $pageTitle }}</h3></div>
            @include('subscriptions.partials.subscription-show')
        </div>
    </div>
    <div class="col-md-3 text-center">
        <legend>{{ __('app.action') }}</legend>
        <p>{!! link_to_route('subscriptions.edit', __('subscription.edit'), [$subscription->id], ['class' => 'btn btn-warning']) !!}</p>
        <p>{!! link_to_route('subscriptions.index', __('subscription.back_to_index'), [], ['class' => 'btn btn-default']) !!}</p>
    </div>
</div>
@endsection
