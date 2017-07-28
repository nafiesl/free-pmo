@extends('layouts.app')

@section('content')
<h1 class="page-header">Profil {{ trans('user.user') }}</h1>
<div class="row">
    <div class="col-md-6">
        {!! Form::model($user, ['route'=>'auth.profile','method'=>'patch']) !!}
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">Profil User</h3></div>
            <div class="panel-body">
                <table class="table">
                    <tr><th>{{ trans('user.user_id') }}</th><td>{{ $user->id }}</td></tr>
                    <tr>
                        <th>{{ trans('app.name') }}</th>
                        <td>
                            {{-- {!! Form::text('name', null, ['class'=>'form-control']) !!} --}}
                            {{-- {!! $errors->first('name', '<span class="form-error">:message</span>') !!} --}}
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('user.roles') }}</th>
                        <td>{{ $user->present()->displayRoles }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('user.permissions') }}</th>
                        <td>{{ $user->present()->displayPermissions }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">
                {{-- {!! Form::submit(trans('app.update'), ['class'=>'btn btn-info']) !!} --}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection