@inject('roles', 'App\Entities\Users\Role')
@extends('layouts.dashboard')

@section('title', trans('user.create'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-6">
        {!! Form::open(['route'=>'users.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('user.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('app.name')]) !!}
                {!! FormField::email('email', ['label' => trans('user.email')]) !!}
                {!! FormField::checkboxes('role', $roles::toArray(), ['label' => trans('user.role')]) !!}

                {!! FormField::password('password', [
                    'label' => trans('auth.password'),
                    'info' => [
                        'text' => 'Kosongkan field ini jika ingin menggunakan <b>password default</b>.',
                        'class' => 'info',
                    ],
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
