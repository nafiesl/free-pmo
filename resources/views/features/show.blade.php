@extends('layouts.app')

@section('title', trans('feature.show'))

@section('content')
<h1 class="page-header">{{ $feature->name }} <small>{{ trans('feature.show') }}</small></h1>
<div class="row">
    <div class="col-md-6">
        @include('features.partials.feature-show')
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show', ['project' => $feature->project])
    </div>
</div>
@endsection