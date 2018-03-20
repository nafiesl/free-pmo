@extends('layouts.guest')

@section('title', __('auth.reset_password'))

@section('content')
<div class="col-md-6 col-md-offset-3">
    <div class="login-panel panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ __('auth.reset_password') }}</h3></div>
        {!! Form::open(['route' => 'reset-password']) !!}
        <div class="panel-body">
            <p>{{ __('auth.reset_password_hint') }} :</p>
            {!! FormField::email('email') !!}
            {!! FormField::password('password', ['label' => __('auth.new_password')]) !!}
            {!! FormField::password('password_confirmation', ['label' => __('auth.new_password_confirmation')]) !!}
            {!! Form::hidden('token', $token) !!}
        </div>
        <div class="panel-footer">
            {!! Form::submit(__('auth.reset_password'), ['class'=>'btn btn-info']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
