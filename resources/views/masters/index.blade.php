@extends('layouts.app')

@section('title', trans('master.masters'))

@section('content')
<h1 class="page-header">
    {!! link_to_route('masters.create', trans('master.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    {{ trans('master.masters') }} <small>{{ $masters->total() }} {{ trans('master.found') }}</small>
</h1>
<div class="well well-sm">
    {!! Form::open(['method'=>'get','class'=>'form-inline']) !!}
    {!! Form::text('q', Request::get('q'), ['class'=>'form-control index-search-field','placeholder'=>trans('master.search'),'style' => 'width:350px']) !!}
    {!! Form::submit(trans('master.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {!! link_to_route('masters.index','Reset',[],['class' => 'btn btn-default btn-sm']) !!}
    {!! Form::close() !!}
</div>
<table class="table table-condensed">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('app.name') }}</th>
        <th>{{ trans('app.description') }}</th>
        <th>{{ trans('app.created_at') }}</th>
        <th>{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($masters as $key => $master)
        <tr>
            <td>{{ $masters->firstItem() + $key }}</td>
            <td>{{ $master->name }}</td>
            <td>{{ $master->description }}</td>
            <td>{{ $master->created_at }}</td>
            <td>
                {!! link_to_route('masters.show',trans('app.show'),[$master->id],['class'=>'btn btn-info btn-xs']) !!}
                {!! link_to_route('masters.edit',trans('app.edit'),[$master->id],['class'=>'btn btn-warning btn-xs']) !!}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">{{ trans('master.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $masters->appends(Request::except('page'))->render()) !!}
@endsection
