@extends('layouts.app')

@section('title', 'Daftar ' . $status . ' Project')

@section('content')
<h1 class="page-header">
    {!! link_to_route('projects.create', trans('project.create'), [], ['class'=>'btn btn-success pull-right']) !!}
    Daftar {{ $status }} Project <small>{{ $projects->total() }} {{ trans('project.found') }}</small>
</h1>
<div class="well well-sm text-right">
    <div class="pull-left hidden-xs">{!! str_replace('/?', '?', $projects->appends(Request::except('page'))->render()) !!}</div>
    {!! Form::open(['method'=>'get','class'=>'form-inline']) !!}
    {!! Form::text('q', Request::get('q'), ['class'=>'form-control index-search-field','placeholder'=>trans('project.search'),'style' => 'width:350px']) !!}
    {!! Form::submit(trans('project.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {!! link_to_route('projects.index','Reset',[],['class' => 'btn btn-default btn-sm']) !!}
    {!! Form::close() !!}
</div>
<table class="table table-condensed table-hover">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th>{{ trans('project.name') }}</th>
        <th class="text-center">{{ trans('project.start_date') }}</th>
        <th class="text-center">{{ trans('project.work_duration') }}</th>
        {{-- <th class="text-center">{{ trans('project.payments') }}</th> --}}
        {{-- <th class="text-right">{{ trans('project.project_value') }}</th> --}}
        <th class="text-center">{{ trans('app.status') }}</th>
        <th>{{ trans('project.customer') }}</th>
        <th>{{ trans('app.action') }}</th>
    </thead>
    <tbody>
        @forelse($projects as $key => $project)
        <tr>
            <td>{{ $projects->firstItem() + $key }}</td>
            <td>{{ $project->name }}</td>
            <td class="text-center">{{ $project->start_date }}</td>
            <td class="text-right">{{ $project->present()->workDuration }}</td>
            {{-- <td class="text-center">{{ $project->payments_count }}</td> --}}
            {{-- <td class="text-right">{{ formatRp($project->project_value) }}</td> --}}
            <td class="text-center">{{ $project->present()->status }}</td>
            <td>{{ $project->customer->name }}</td>
            <td>
                {!! link_to_route('projects.show',trans('app.show'),[$project->id],['class'=>'btn btn-info btn-xs']) !!}
                {!! link_to_route('projects.edit',trans('app.edit'),[$project->id],['class'=>'btn btn-warning btn-xs']) !!}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">{{ $status }} {{ trans('project.not_found') }}</td>
        </tr>
        @endforelse
    </tbody>
</table>
    {!! str_replace('/?', '?', $projects->appends(Request::except('page'))->render()) !!}
@endsection
