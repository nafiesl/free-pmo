@extends('layouts.app')

@section('title', trans('feature.show') . ' | ' . $feature->name . ' | ' . $feature->project->name)

@section('content')
@include('features.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        {!! html_link_to_route('features.create', trans('feature.create'), [$feature->project_id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
        {!! link_to_route('features.edit', trans('feature.edit'), [$feature->id], ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('projects.features', trans('feature.back_to_index'), [$feature->project_id, '#' . $feature->id], ['class' => 'btn btn-default']) !!}
    </div>
    {{ $feature->name }} <small>{{ trans('feature.show') }}</small>
</h1>
<div class="row">
    <div class="col-md-5">
        @include('features.partials.feature-show')
    </div>
    <div class="col-sm-7">
        @include('features.partials.feature-tasks-operation')
    </div>
</div>
@include('features.partials.feature-tasks')
@endsection