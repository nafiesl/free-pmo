@extends('layouts.app')

@section('title', trans('subscription.show'))

@section('content')
<h1 class="page-header">{{ $subscription->domain_name }} <small>{{ trans('subscription.show') }}</small></h1>
<div class="row">
    <div class="col-md-4">
        @include('subscriptions.partials.subscription-show')
    </div>
</div>
@endsection