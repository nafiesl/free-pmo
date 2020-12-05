@extends('layouts.dashboard')

@section('title', trans('user.list'))

@section('content-dashboard')

<div class="panel panel-default">
    <div class="panel-heading">
        {!! html_link_to_route('users.create', trans('user.create'), [], [
            'class'=>'btn btn-success btn-xs pull-right',
            'style' => 'margin:-2px 0',
            'icon' => 'plus'
        ]) !!}
        <h3 class="panel-title">{{ __('user.list') }}</h3>
    </div>
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('app.name') }}</th>
            <th>{{ trans('user.email') }}</th>
            <th>{{ trans('user.role') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($users as $key => $user)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $user->nameLink() }}</td>
                <td>{{ $user->email }}</td>
                <td>{!! $user->roleList() !!}</td>
                <td>
                    {!! link_to_route('users.show',trans('user.show'),[$user->id],['class'=>'btn btn-info btn-xs']) !!}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">{{ trans('user.not_found') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
