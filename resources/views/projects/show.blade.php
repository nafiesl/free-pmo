@extends('layouts.app')

@section('title', trans('project.show'))

@section('content')
@include('projects.partials.breadcrumb')

<h1 class="page-header">{{ $project->name }} <small>{{ trans('project.show') }}</small></h1>

@include('projects.partials.nav-tabs')

<div class="row">
    <div class="col-md-6">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection