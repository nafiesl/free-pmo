@extends('layouts.app')

@section('title')
@yield('subtitle', __('project.detail')) - {{ $project->name }}
@endsection

@section('content')
@include('projects.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        @yield('action-buttons')
    </div>
    {{ $project->name }} <small>@yield('subtitle', __('project.detail'))</small>
</h1>

@include('projects.partials.nav-tabs')

@yield('content-project')

@endsection
