@extends('layouts.app')

@section('title', trans('payment.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::delete(['route'=>['payments.destroy',$payment->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['payment_id'=>$payment->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('payments.show', trans('app.cancel'), [$payment->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-5">
        @include('payments.partials.payment-show')
    </div>
</div>
@endsection