@extends('layouts.app')

@section('title', trans('project.show') . ' | ' . $project->name)

@section('content')
@include('projects.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        {!! link_to_route('projects.edit', trans('project.edit'), [$project->id], ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('projects.index', trans('project.back_to_index'), ['status' => $project->status_id], ['class' => 'btn btn-default']) !!}
    </div>
    {{ $project->name }} <small>{{ trans('project.show') }}</small>
</h1>

@include('projects.partials.nav-tabs')

<div class="row">
    <div class="col-md-6">
        @include('projects.partials.project-show')
    </div>
    <div class="col-md-6">
        {!! Form::model($project, ['route' => ['projects.status-update', $project->id], 'method' => 'patch','class' => 'well well-sm form-inline']) !!}
        {!! FormField::select('status_id', getProjectStatusesList(), ['label' => trans('project.status')]) !!}
        {!! Form::submit('Update Project Status', ['class' => 'btn btn-info']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection