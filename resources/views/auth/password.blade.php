@extends('layouts.guest')

@section('title', trans('auth.reset_password'))

@section('content')
<div class="col-md-4 col-md-offset-4">
	<div class="login-panel panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Reset Password</h3></div>
		<div class="panel-body">
            @include('auth.partials._notifications')
			{!! Form::open(['route'=>'auth.forgot-password']) !!}
            {!! FormField::email('email') !!}
            {!! Form::submit(trans('auth.send_reset_password_link'), ['class'=>'btn btn-success btn-block']) !!}
            {!! link_to_route('auth.login','Back to Login', [],['class'=>'btn btn-default btn-block']) !!}
            {!! Form::close() !!}
		</div>
    </div>
</div>
@endsection
