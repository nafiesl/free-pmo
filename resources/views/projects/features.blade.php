@extends('layouts.app')

@section('title', trans('project.features'))

@section('content')
@include('projects.partials.breadcrumb',['title' => trans('project.features')])

<h1 class="page-header">{{ $project->name }} <small>{{ trans('project.features') }}</small></h1>

@include('projects.partials.nav-tabs')

<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('feature.name') }}</th>
            <th>{{ trans('feature.tasks_count') }}</th>
            <th>{{ trans('feature.progress') }}</th>
            <th>{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($project->features as $feature)
            <tr>
                <td>{{ $feature->name }}</td>
            </tr>
            @empty
            <tr><td colspan="5">{{ trans('feature.empty') }}</td></tr>
            @endforelse
            <tr><td colspan="5">{!! html_link_to_route('features.create', trans('feature.create'), [$project->id], ['class' => 'btn btn-primary','icon' => 'plus']) !!}</td></tr>
        </tbody>
    </table>
</div>
@endsection