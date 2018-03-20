@extends('layouts.guest')

@section('title', __('auth.reset_password'))

@section('content')
<div class="col-md-4 col-md-offset-4">
	<div class="login-panel panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">{{ __('auth.reset_password') }}</h3></div>
		<div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
			{!! Form::open(['route'=>'auth.reset-email']) !!}
            {!! FormField::email('email') !!}
            {!! Form::submit(__('auth.send_reset_password_link'), ['class'=>'btn btn-success btn-block']) !!}
            {!! link_to_route('auth.login', __('passwords.back_to_login'), [], ['class'=>'btn btn-default btn-block']) !!}
            {!! Form::close() !!}
		</div>
    </div>
</div>
@endsection
