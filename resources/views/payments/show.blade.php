@extends('layouts.app')

@section('title', trans('payment.show'))

@section('content')
@include('payments.partials.breadcrumb')
<h1 class="page-header">{{ trans('payment.show') }}</h1>
<div class="row">
    <div class="col-md-5">
        @include('payments.partials.payment-show')
    </div>
</div>
@endsection