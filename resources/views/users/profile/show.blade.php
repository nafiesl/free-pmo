@extends('layouts.dashboard')

@section('title', trans('auth.profile'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <table class="table">
                <tr><th class="col-xs-3">{{ trans('user.user_id') }}</th><td>{{ $user->id }}</td></tr>
                <tr><th>{{ trans('user.name') }}</th><td>{{ $user->name }}</td></tr>
                <tr><th>{{ trans('user.email') }}</th><td>{{ $user->email }}</td></tr>
                <tr><th>{{ trans('user.role') }}</th><td>{!! $user->roleList() !!}</td></tr>
                <tr><th>{{ trans('user.api_token') }}</th><td><code>{{ $user->api_token }}</code></td></tr>
                <tr><th>{{ trans('lang.lang') }}</th><td>{{ trans('lang.'.$user->lang) }}</td></tr>
            </table>
            <div class="panel-footer">
                {{ link_to_route('users.profile.edit', trans('auth.profile_edit'), [], ['class' => 'btn btn-info']) }}
            </div>
        </div>
    </div>
</div>
@endsection
