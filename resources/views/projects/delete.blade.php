@extends('layouts.app')

@section('title', trans('project.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::delete(['route'=>['projects.destroy',$project->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['project_id'=>$project->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('projects.show', trans('app.cancel'), [$project->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-6 col-md-offset-2">
        @include('projects.partials.project-show')
    </div>
</div>
@endsection
