@extends('layouts.app')

@section('title', __('job.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::delete([
            'route' => ['jobs.destroy', $job]],
            __('app.delete_confirm_button'),
            ['class' => 'btn btn-danger'],
            [
                'job_id' => $job->id,
                'project_id' => $job->project_id,
            ]) !!}
    </div>
    {{ __('app.delete_confirm') }}
    {{link_to_route('jobs.show', __('app.cancel'), [$job], ['class' => 'btn btn-default']) }}
</h1>
<div class="row">
    <div class="col-md-4">
        @include('jobs.partials.job-show')
    </div>
</div>
@endsection
