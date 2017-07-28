@extends('layouts.app')

@section('title', trans('user.edit'))

@section('content')
<h1 class="page-header">{{ $user->name }} <small>Edit {{ trans('user.user') }}</small></h1>
{!! Form::model($user, ['route'=>['users.update', $user->id], 'method' => 'patch']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('user.show') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('app.name')]) !!}
                {!! FormField::email('email', ['label' => trans('user.email')]) !!}

                {!! FormField::password('password', [
                    'label' => trans('auth.password'),
                    'info' => [
                        'text' => 'Isi field ini jika ingin mengganti password user.',
                        'class' => 'info',
                    ],
                ]) !!}

                {!! FormField::password('password_confirmation', [
                    'label' => trans('auth.password_confirmation')
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('user.roles') }}</h3></div>
            <div class="panel-body">
                {!! FormField::checkboxes('role', $roles, ['label' => false, 'value' => $user->roles]) !!}
            </div>
        </div>
    </div>
</div>
<div class="panel-footer">
    {!! Form::submit(trans('user.update'), ['class'=>'btn btn-warning']) !!}
    {!! link_to_route('users.show', trans('app.show'), [$user->id], ['class' => 'btn btn-info']) !!}
    {!! link_to_route('users.index', trans('user.back_to_index'), [], ['class' => 'btn btn-default']) !!}
    {!! link_to_route('users.delete', trans('app.delete'), [$user->id], ['class'=>'btn btn-danger pull-right']) !!}
</div>
{!! Form::close() !!}
@endsection