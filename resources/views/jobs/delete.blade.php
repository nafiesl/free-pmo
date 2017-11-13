@extends('layouts.app')

@section('title', trans('job.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::delete([
            'route'=>['jobs.destroy',$job->id]],
            trans('app.delete_confirm_button'),
            ['class'=>'btn btn-danger'],
            [
                'job_id'=>$job->id,
                'project_id'=>$job->project_id,
            ]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('jobs.show', trans('app.cancel'), [$job->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-4">
        @include('jobs.partials.job-show')
    </div>
</div>
@endsection
