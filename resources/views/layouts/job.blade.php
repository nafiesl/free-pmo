@extends('layouts.app')

@section('title')
@yield('subtitle', __('job.detail')) - {{ $job->name }}
@endsection

@section('content')
@include('jobs.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        @yield('action-buttons')
        {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id, '#' . $job->id], ['class' => 'btn btn-default']) }}
    </div>
    {{ $job->name }} <small>@yield('subtitle', __('job.detail'))</small>
</h1>

@include('jobs.partials.nav-tabs')

@yield('content-job')

@endsection
