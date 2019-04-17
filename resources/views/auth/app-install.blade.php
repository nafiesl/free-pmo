@extends('layouts.guest')

@section('title', 'Install '.config('app.name'))

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h2 class="page-header text-center text-muted">{!! __('app_install.header') !!}</h2>
    <div class="panel panel-default">
        <div class="panel-body">
        	{!! Form::open(['route' => 'app.install']) !!}
            <div class="row">
                <div class="col-sm-6">
                    <div class="text-center">
                        {!! app_logo_image(['style' => 'width:150px']) !!}
                        <h3>{{ config('app.name') }}</h3>
                    </div>
                </div>
                <div class="col-sm-6">
                    <p>{{ __('app_install.agency_info_text') }}</p>
                    {!! FormField::text('agency_name', ['required' => true, 'label' => __('agency.name')]) !!}
                    {!! FormField::text('agency_website', ['label' => __('agency.website'), 'placeholder' => 'https://yourdomain.com']) !!}
                </div>
            </div>
            <hr style="margin: 10px 0;">
            <p>{{ __('app_install.admin_info_text') }}</p>
            <div class="row">
                <div class="col-sm-6">
                    {!! FormField::text('name', ['required' => true, 'label' => __('app_install.admin_name')]) !!}
                </div>
                <div class="col-sm-6">
                    {!! FormField::email('email', ['required' => true, 'label' => __('app_install.admin_email')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    {!! FormField::password('password', ['required' => true, 'label' => __('auth.password')]) !!}
                </div>
                <div class="col-sm-6">
                    {!! FormField::password('password_confirmation', ['required' => true, 'label' => __('auth.password_confirmation')]) !!}
                </div>
            </div>
			{!! Form::submit(__('app_install.button'), ['class' => 'btn btn-success btn-block btn-lg']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
