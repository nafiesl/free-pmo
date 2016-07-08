@extends('layouts.app')

@section('title', trans('subscription.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! delete_button(['route'=>['subscriptions.destroy',$subscription->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['subscription_id'=>$subscription->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('subscriptions.show', trans('app.cancel'), [$subscription->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-4">
        @include('subscriptions.partials.subscription-show')
    </div>
</div>
@endsection