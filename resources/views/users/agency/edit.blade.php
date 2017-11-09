@extends('layouts.dashboard')

@section('title', trans('agency.edit'))

@section('content-dashboard')
<div class="row">
    {{ Form::open(['route' => 'users.agency.update', 'method' => 'patch']) }}
    <div class="col-md-4">
        <legend>{{ trans('agency.detail') }}</legend>
        {!! FormField::text('name', ['value' => Option::get('agency_name')]) !!}
        {!! FormField::text('tagline', ['value' => Option::get('agency_tagline')]) !!}
        {{ Form::submit(trans('agency.update'), ['class' => 'btn btn-info']) }}
        {{ link_to_route('users.agency.show', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        <br>
        <br>
    </div>
    <div class="col-md-5">
        <legend>{{ trans('contact.contact') }}</legend>
        <div class="row">
            <div class="col-md-6">{!! FormField::email('email', ['value' => Option::get('agency_email')]) !!}</div>
            <div class="col-md-6">{!! FormField::text('phone', ['value' => Option::get('agency_phone')]) !!}</div>
        </div>
        {!! FormField::textarea('address', ['value' => Option::get('agency_address')]) !!}
        {!! FormField::text('website', ['value' => Option::get('agency_website')]) !!}
    </div>
    {{ Form::close() }}
    <div class="col-md-3">
        {{ Form::open(['route' => 'users.agency.logo-upload', 'method' => 'patch', 'files' => true]) }}
        <legend>{{ trans('agency.logo') }}</legend>
        <p>{!! appLogoImage() !!}</p>
        {!! FormField::file('logo', ['label' => trans('agency.logo_change')]) !!}
        {{ Form::submit(trans('agency.logo_upload'), ['class' => 'btn btn-default']) }}
        {{ Form::close() }}
    </div>
</div>

@endsection
