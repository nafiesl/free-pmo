@extends('layouts.app')

@section('title', trans('customer.detail'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! link_to_route('customers.edit', trans('customer.edit'), [$customer->id], ['id' => 'edit-customer-' . $customer->id, 'class' => 'btn btn-warning']) !!}
        {!! link_to_route('customers.index', trans('customer.back_to_index'), [], ['class' => 'btn btn-default']) !!}
    </div>

    {{ $customer->name }} <small>@yield('title')</small>
</h1>
@include('customers.partials.nav-tabs')
@yield('content-customer')
@endsection
