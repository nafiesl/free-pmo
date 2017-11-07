@extends('layouts.app')

@section('title', trans('subscription.detail'))

@section('content')
@include('subscriptions.partials.breadcrumb')

<h1 class="page-header">{{ $subscription->name }} <small>{{ trans('subscription.detail') }}</small></h1>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('subscription.detail') }}</h3></div>
            @include('subscriptions.partials.subscription-show')
            <div class="panel-footer">
                {!! link_to_route('subscriptions.edit', trans('subscription.edit'), [$subscription->id], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('subscriptions.index', trans('subscription.back_to_index'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
</div>
@endsection
