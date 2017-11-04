@extends('layouts.dashboard')

@section('title', trans('agency.edit'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-6 col-lg-offset-2">
        {{ Form::open(['route' => 'users.agency.update', 'method' => 'patch']) }}
        {!! FormField::text('name', ['value' => Option::get('agency_name')]) !!}
        {!! FormField::email('email', ['value' => Option::get('agency_email')]) !!}
        {!! FormField::text('website', ['value' => Option::get('agency_phone')]) !!}
        {!! FormField::textarea('address', ['value' => Option::get('agency_address')]) !!}
        {!! FormField::text('phone', ['value' => Option::get('agency_website')]) !!}
        {{ Form::submit(trans('agency.update'), ['class' => 'btn btn-info']) }}
        {{ link_to_route('users.agency.show', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        {{ Form::close() }}
    </div>
</div>

@endsection
