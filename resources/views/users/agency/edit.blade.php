@extends('layouts.dashboard')

@section('title', __('agency.edit'))

@section('content-dashboard')
<div class="row">
    {{ Form::open(['route' => 'users.agency.update', 'method' => 'patch']) }}
    <div class="col-md-4">
        <legend>{{ __('agency.detail') }}</legend>
        {!! FormField::text('name', ['value' => Option::get('agency_name')]) !!}
        {!! FormField::text('tagline', ['value' => Option::get('agency_tagline')]) !!}
        {{ Form::submit(__('agency.update'), ['class' => 'btn btn-info']) }}
        {{ link_to_route('users.agency.show', __('app.cancel'), [], ['class' => 'btn btn-default']) }}
        <br>
        <br>
    </div>
    <div class="col-md-5">
        <legend>{{ __('contact.contact') }}</legend>
        <div class="row">
            <div class="col-md-6">{!! FormField::email('email', ['value' => Option::get('agency_email')]) !!}</div>
            <div class="col-md-6">{!! FormField::text('phone', ['value' => Option::get('agency_phone')]) !!}</div>
        </div>
        {!! FormField::textarea('address', ['value' => Option::get('agency_address')]) !!}
        <div class="row">
            <div class="col-md-6">{!! FormField::text('city', ['value' => Option::get('agency_city')]) !!}</div>
            <div class="col-md-6">{!! FormField::text('website', ['value' => Option::get('agency_website')]) !!}</div>
        </div>
        {!! FormField::text('tax_id', ['label' => __('agency.tax_id'), 'value' => Option::get('agency_tax_id')]) !!}
    </div>
    {{ Form::close() }}
    <div class="col-md-3 text-center">
        {{ Form::open(['route' => 'users.agency.logo-upload', 'method' => 'patch', 'files' => true]) }}
        <legend>{{ __('agency.logo') }}</legend>
        <p>{!! app_logo_image(['style' => 'margin:20px auto']) !!}</p>
        {!! FormField::file('logo', [
            'label' => __('agency.logo_change'),
            'info' => ['text' => __('agency.logo_upload_info'), 'class' => 'warning'],
        ]) !!}
        {{ Form::submit(__('agency.logo_upload'), ['class' => 'btn btn-default']) }}
        {{ Form::close() }}
    </div>
</div>

@endsection
