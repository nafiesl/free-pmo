@extends('layouts.app')

@section('content')
<ul class="breadcrumb hidden-print">
    <li class="active">{{ trans('auth.profile') }}</li>
</ul>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {!! Form::model($user, ['route'=>'auth.profile','method'=>'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('auth.profile') }}</h3></div>
            <div class="panel-body">
                <table class="table">
                    <tr><th>{{ trans('user.user_id') }}</th><td>{{ $user->id }}</td></tr>
                    <tr>
                        <th>{{ trans('user.name') }}</th>
                        <td>{!! FormField::text('name', ['label' => false]) !!}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('user.email') }}</th>
                        <td>{!! FormField::email('email', ['label' => false]) !!}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('user.api_token') }}</th>
                        <td>{{ $user->api_token }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('user.roles') }}</th>
                        <td>{{ $user->present()->displayRoles }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('app.update'), ['class'=>'btn btn-info']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection