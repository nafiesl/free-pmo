@extends('layouts.guest')

@section('title', trans('auth.login'))

@section('content')
@include('flash::message')
<div class="login-panel col-md-4 col-md-offset-4 text-center">
    {{ Html::image(url('assets/imgs/logo.png'), 'Logo '.Option::get('agency_name','Aplikasi Laravel')) }}
    <h3>{{ Option::get('app_name','Aplikasi Laravel') }}</h3>
    <div class="panel panel-default">
        <div class="panel-body">
            @include('auth.partials._notifications')
        	{{ Form::open(['route'=>'auth.login']) }}
            {!! FormField::email('email', ['label' => false, 'placeholder'=> trans('auth.email')]) !!}
            {!! FormField::password('password', ['label' => false, 'placeholder'=> trans('auth.password')]) !!}
            {{ Form::submit(trans('auth.login'), ['class'=>'btn btn-success btn-block']) }}
            <div class="row">
                <div class="col-md-6">
                    {{ link_to_route('auth.register', trans('auth.need_account'),[],['class'=>'btn btn-link']) }}
                </div>
                <div class="col-md-6">
                    {{ link_to_route('auth.reset-request', trans('auth.forgot_password'), [], ['class'=>'btn btn-link']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
