@extends('layouts.app')

@section('title', trans('auth.change_password'))

@section('content')
<br>
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('auth.change_password') }}</h3></div>
        {!! Form::open(['route'=>'auth.change-password']) !!}
        <div class="panel-body">
            @include('auth.partials._notifications')
            {!! FormField::password('old_password', ['label'=> trans('auth.old_password')]) !!}
            {!! FormField::password('password', ['label'=>trans('auth.new_password')]) !!}
            {!! FormField::password('password_confirmation', ['label'=>trans('auth.new_password_confirmation')]) !!}
        </div>
        <div class="panel-footer">
            {!! Form::submit(trans('auth.change_password'), ['class'=>'btn btn-info']) !!}
            {!! link_to_route('home',trans('app.cancel'),[],['class'=>'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
