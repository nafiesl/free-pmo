@extends('layouts.dashboard')

@section('title', trans('nav_menu.dashboard'))

@section('content-dashboard')

<div class="row">
    <div class="col-lg-3 col-md-6">
        @include('view-components.dashboard-panel', [
            'class' => 'default',
            'icon' => 'paperclip',
            'number' => array_key_exists(1, $projectsCount) ? $projectsCount[1] : 0,
            'text' => getProjectStatusesList(1),
            'linkRoute' => route('projects.index',['status' => 1]),
        ])
    </div>
    <div class="col-lg-3 col-md-6">
        @include('view-components.dashboard-panel', [
            'class' => 'yellow',
            'icon' => 'tasks',
            'number' => array_key_exists(2, $projectsCount) ? $projectsCount[2] : 0,
            'text' => getProjectStatusesList(2),
            'linkRoute' => route('projects.index',['status' => 2]),
        ])
    </div>
    <div class="col-lg-3 col-md-6">
        @include('view-components.dashboard-panel', [
            'class' => 'primary',
            'icon' => 'thumbs-o-up',
            'number' => array_key_exists(3, $projectsCount) ? $projectsCount[3] : 0,
            'text' => getProjectStatusesList(3),
            'linkRoute' => route('projects.index',['status' => 3]),
        ])
    </div>
    <div class="col-lg-3 col-md-6">
        @include('view-components.dashboard-panel', [
            'class' => 'green',
            'icon' => 'money',
            'number' => array_key_exists(4, $projectsCount) ? $projectsCount[4] : 0,
            'text' => getProjectStatusesList(4),
            'linkRoute' => route('projects.index',['status' => 4]),
        ])
    </div>
    <div class="col-lg-3 col-md-6 col-lg-offset-3">
        @include('view-components.dashboard-panel', [
            'class' => 'danger',
            'icon' => 'fa-smile-o',
            'number' => array_key_exists(5, $projectsCount) ? $projectsCount[5] : 0,
            'text' => getProjectStatusesList(5),
            'linkRoute' => route('projects.index',['status' => 5]),
        ])
    </div>
    <div class="col-lg-3 col-md-6">
        @include('view-components.dashboard-panel', [
            'class' => 'warning',
            'icon' => 'hand-paper-o',
            'number' => array_key_exists(6, $projectsCount) ? $projectsCount[6] : 0,
            'text' => getProjectStatusesList(6),
            'linkRoute' => route('projects.index',['status' => 6]),
        ])
    </div>
</div>
@endsection
