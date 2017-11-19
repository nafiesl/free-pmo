@extends('layouts.guest')

@section('title', trans('auth.register'))

@section('content')
<div class="col-md-6 col-md-offset-3">
    <div class="login-panel panel panel-default">
        <div class="panel-body">
            <div class="text-center">
                {!! appLogoImage(['style' => 'width:150px']) !!}
                <h3>{{ config('app.name') }}</h3>
            </div>
            <hr>
        	{!! Form::open(['route' => 'app.install', 'class' => '']) !!}
            <p>Silakan isi formulir di bawah ini untuk membuat akun Administrator dan Agensi.</p>
            <div class="row">
                <div class="col-md-6">
                    {!! FormField::text('agency_name', ['required' => true, 'label' => trans('agency.name')]) !!}
                </div>
                <div class="col-md-6">
                    {!! FormField::text('agency_website', ['required' => true, 'label' => trans('agency.website')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {!! FormField::text('name', ['required' => true, 'label' => trans('user.name')]) !!}
                </div>
                <div class="col-md-6">
                    {!! FormField::email('email', ['required' => true, 'label' => trans('auth.email')]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {!! FormField::password('password', ['required' => true, 'label' => trans('auth.password')]) !!}
                </div>
                <div class="col-md-6">
                    {!! FormField::password('password_confirmation', ['required' => true, 'label' => trans('auth.password_confirmation')]) !!}
                </div>
            </div>
            <div class="form-group">
				{!! Form::submit(trans('auth.register'), ['class' => 'btn btn-success']) !!}
			</div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
