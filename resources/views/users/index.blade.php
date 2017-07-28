@extends('layouts.app')

@section('title', trans('user.users'))

@section('content')
<h1 class="page-header">
    {!! link_to_route('users.create', trans('user.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    {{ trans('user.users') }} <small>{{ $users->total() }} {{ trans('user.found') }}</small>
</h1>
<div class="well well-sm">
    {!! Form::open(['method'=>'get','class'=>'form-inline']) !!}
    @if (Request::has('role'))
    {!! Form::hidden('role', Request::get('role')) !!}
    @endif
    {!! Form::text('q', Request::get('q'), ['class'=>'form-control','placeholder'=>trans('user.search'),'style' => 'width:350px']) !!}
    {!! Form::submit('Cari Member', ['class' => 'btn btn-info btn-sm']) !!}
    {!! link_to_route('users.index','Reset',['role' => Request::get('role')],['class' => 'btn btn-default btn-sm']) !!}
    {!! Form::close() !!}
</div>

<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('app.name') }}</th>
        <th>{{ trans('user.email') }}</th>
        <th>{{ trans('user.roles') }}</th>
        <th>{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($users as $key => $user)
        <tr>
            <td>{{ $users->firstItem() + $key }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{!! $user->present()->roleslink !!}</td>
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
    {!! str_replace('/?', '?', $users->appends(Request::except('page'))->render()) !!}
@endsection
