@extends('layouts.dashboard')

@section('title', trans('user.show'))

@section('content-dashboard')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $user->name }} - {{ trans('user.show') }}</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ trans('app.name') }}</th><td>{{ $user->name }}</td></tr>
                        <tr><th>{{ trans('user.email') }}</th><td>{{ $user->email }}</td></tr>
                        <tr><th>{{ trans('user.registered_at') }}</th><td>{{ $user->created_at }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                {!! link_to_route('users.edit', trans('user.edit'), [$user->id], ['class' => 'btn btn-warning']) !!}
                {!! link_to_route('users.index', trans('user.back_to_index'), [], ['class' => 'btn btn-default']) !!}
            </div>
        </div>
    </div>
</div>
@endsection
