@extends('layouts.user')

@section('content-user')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <table class="table">
                <tr><th class="col-xs-3">{{ trans('user.user_id') }}</th><td>{{ $user->id }}</td></tr>
                <tr><th>{{ trans('user.name') }}</th><td>{{ $user->name }}</td></tr>
                <tr><th>{{ trans('user.email') }}</th><td>{{ $user->email }}</td></tr>
                <tr><th>{{ trans('user.role') }}</th><td>{!! $user->roleList() !!}</td></tr>
                <tr><th>{{ trans('lang.lang') }}</th><td>{{ trans('lang.'.$user->lang) }}</td></tr>
            </table>
            <div class="panel-footer">
                {!! link_to_route('users.edit', trans('user.edit'), [$user->id], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('users.index', trans('user.back_to_index'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
</div>
@endsection
