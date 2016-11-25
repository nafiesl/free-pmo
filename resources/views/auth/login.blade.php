@extends('layouts.guest')

@section('title', trans('auth.login'))

@section('content')
<div class="login-panel col-md-4 col-md-offset-4">
    <div class="text-center">
        <img src="{{ url('assets/imgs/logo.png') }}" alt="Logo {{ Option::get('app_owner') }}">
    </div>
    <h3 class="text-center">{{ Option::get('app_name','Aplikasi Laravel') }}</h3>
    <div class="panel panel-default">
        <div class="panel-body">
            @include('flash::message')
            @include('auth.partials._errors')
        	{!! Form::open(['route'=>'auth.login']) !!}
            <div class="form-group {!! $errors->has('username') ? 'has-error' : ''; !!}">
                {!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=> trans('auth.username')]) !!}
            </div>
            <div class="form-group {!! $errors->has('password') ? 'has-error' : ''; !!}">
                {!! Form::password('password', ['class'=>'form-control', 'placeholder'=> trans('auth.password')]) !!}
            </div>
            <div class="checkbox">
                <label><input name="remember" type="checkbox" value="Remember Me">Remember Me</label>
                {!! link_to_route('auth.reset-request', trans('auth.forgot_password'),[],['class'=>'pull-right']) !!}
            </div>
            {!! Form::submit(trans('auth.login'), ['class'=>'btn btn-success btn-block']) !!}
            {!! link_to_route('auth.register', trans('auth.need_account'),[],['class'=>'btn btn-info btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection