@extends('layouts.guest')

@section('title', trans('auth.login'))

@section('content')
@include('flash::message')
<div class="login-panel col-md-4 col-md-offset-4 text-center">
    {!! appLogoImage() !!}
    <h3>{{ config('app.name') }}</h3>
    <div class="panel panel-default">
        <div class="panel-body">
        	{{ Form::open(['route'=>'auth.login']) }}
            {!! FormField::email('email', ['label' => false, 'placeholder'=> trans('auth.email')]) !!}
            {!! FormField::password('password', ['label' => false, 'placeholder'=> trans('auth.password')]) !!}
            {{ Form::submit(trans('auth.login'), ['class'=>'btn btn-success btn-block']) }}
            {{ link_to_route('auth.reset-request', trans('auth.forgot_password'), [], ['class'=>'btn btn-link']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
