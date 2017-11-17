@extends('layouts.app')

@section('title')
{{ $project->name }} - @yield('subtitle', trans('project.show'))
@endsection

@section('content')
@include('projects.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        @yield('action-buttons')
    </div>
    {{ $project->name }} <small>@yield('subtitle', trans('project.show'))</small>
</h1>

@include('projects.partials.nav-tabs')

@yield('content-project')

@endsection
