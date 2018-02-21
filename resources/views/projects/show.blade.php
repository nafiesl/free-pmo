@extends('layouts.project')

@section('action-buttons')
@can('update', $project)
    {!! link_to_route('projects.edit', trans('project.edit'), [$project->id], ['class' => 'btn btn-warning']) !!}
@endcan
{!! link_to_route('projects.index', trans('project.back_to_index'), ['status' => $project->status_id], ['class' => 'btn btn-default']) !!}
@endsection

@section('content-project')

<div class="row">
    <div class="col-md-6">
        @include('projects.partials.project-show')
    </div>
    <div class="col-md-6">
        {!! Form::model($project, ['route' => ['projects.status-update', $project->id], 'method' => 'patch','class' => 'well well-sm form-inline']) !!}
        {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => trans('project.status')]) !!}
        {!! Form::submit('Update Project Status', ['class' => 'btn btn-info btn-sm']) !!}
        {!! Form::close() !!}
        @include('projects.partials.project-stats')
    </div>
</div>

@endsection
