@extends('layouts.app')

@section('title', trans('user.create'))

@section('content')
<h1 class="page-header">{{ trans('user.create') }}</h1>
<div class="row">
    <div class="col-md-6">
        {!! Form::open(['route'=>'users.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">User Data</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('app.name')]) !!}
                {!! FormField::text('username', ['label' => trans('auth.username')]) !!}
                {!! FormField::email('email', ['label' => trans('user.email')]) !!}
                {!! FormField::checkboxes('role', $roles, ['label' => trans('user.role')]) !!}

                {!! FormField::password('password', [
                    'label' => trans('auth.password'),
                    'info' => [
                        'text' => 'Kosongkan field ini jika ingin menggunakan <b>password default</b>.',
                        'class' => 'info',
                    ],
                ]) !!}

                {!! FormField::password('password_confirmation', [
                    'label' => trans('auth.password_confirmation')
                ]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('user.create'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('users.index', trans('app.cancel'), [], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection