@extends('layouts.app')

@section('title', trans('auth.change_password'))

@section('content')
<ul class="breadcrumb hidden-print">
    <li class="active">{{ trans('auth.change_password') }}</li>
</ul>

<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        {!! Form::open(['route'=>'auth.change-password', 'method' => 'patch']) !!}
        <div class="panel-body">
            {!! FormField::password('old_password', ['label' => false, 'placeholder' => trans('auth.old_password')]) !!}
            {!! FormField::password('password', ['label' => false, 'placeholder' => trans('auth.new_password')]) !!}
            {!! FormField::password('password_confirmation', ['label' => false, 'placeholder' => trans('auth.new_password_confirmation')]) !!}
        </div>
        <div class="panel-footer">
            {!! Form::submit(trans('auth.change_password'), ['class'=>'btn btn-info']) !!}
            {!! link_to_route('home',trans('app.cancel'),[],['class'=>'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
