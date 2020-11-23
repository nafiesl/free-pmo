@extends('layouts.app')

@section('content')

<div class="well well-sm" style="margin-top: 15px;">
    {!! Form::open(['route' => 'projects.index', 'method' => 'get', 'class' => 'form-inline']) !!}
    {!! Form::text('q', null, [
        'class' => 'form-control index-search-field',
        'placeholder' => __('project.search'),
        'style' => 'width:100%;max-width:350px'
    ]) !!}
    {!! Form::submit(__('project.search'), ['class' => 'btn btn-info btn-sm']) !!}
    @can('create', new App\Entities\Projects\Project)
        {{ link_to_route('projects.create', __('project.create'), [], [
            'class' => 'btn btn-success pull-right',
            'style' => 'margin: -2px 0px;'
        ]) }}
    @endcan
    {!! Form::close() !!}
</div>

@include('pages.partials.dashboard-nav-tabs')

@yield('content-dashboard')

@endsection
