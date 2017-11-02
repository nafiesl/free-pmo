@extends('layouts.app')

@section('content')

<div class="well well-sm" style="margin-top: 15px;">
    {!! Form::open(['route' => 'projects.index','method'=>'get','class'=>'form-inline']) !!}
    {!! Form::text('q', Request::get('q'), [
        'class' => 'form-control index-search-field',
        'placeholder' => trans('project.search'),
        'style' => 'width:100%;max-width:350px'
    ]) !!}
    {!! Form::submit(trans('project.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {{ link_to_route('projects.create', trans('project.create'), [], [
        'class' => 'btn btn-success pull-right',
        'style' => 'margin: -2px 0px;'
    ]) }}
    {!! Form::close() !!}
</div>

@include('pages.partials.dashboard-nav-tabs')

@yield('content-dashboard')
@endsection
