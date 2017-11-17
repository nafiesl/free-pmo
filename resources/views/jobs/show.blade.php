@extends('layouts.app')

@section('title', trans('job.show') . ' | ' . $job->name . ' | ' . $job->project->name)

@section('content')
@include('jobs.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        {!! html_link_to_route('projects.jobs.create', trans('job.create'), [$job->project_id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
        {!! link_to_route('jobs.edit', trans('job.edit'), [$job->id], ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('projects.jobs.index', trans('job.back_to_index'), [$job->project_id, '#' . $job->id], ['class' => 'btn btn-default']) !!}
    </div>
    {{ $job->name }} <small>{{ trans('job.show') }}</small>
</h1>
<div class="row">
    <div class="col-md-5">
        @include('jobs.partials.job-show')
    </div>
    <div class="col-sm-7">
        @include('jobs.partials.job-tasks-operation')
    </div>
</div>
@include('jobs.partials.job-tasks')
@endsection

@if (Request::get('action') == 'task_edit' && $editableTask)
@section('ext_css')
    {!! Html::style(url('assets/css/plugins/rangeslider.css')) !!}
    <style>
        .rangeslider--horizontal {
            margin-top: 10px;
            margin-bottom: 10px;
            height: 10px;
        }
        .rangeslider--horizontal .rangeslider__handle {
            top : -5px;
            width: 20px;
            height: 20px;
        }
        .rangeslider--horizontal .rangeslider__handle:after {
            width: 8px;
            height: 8px;
        }
    </style>
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/rangeslider.min.js')) !!}
@endsection

@section('script')
<script>
(function() {
    $('input[type="range"]').rangeslider({ polyfill: false });

    $(document).on('input', 'input[type="range"]', function(e) {
        var ap_weight = e.currentTarget.value;
        $('#ap_weight').text(ap_weight);
    });
})();
</script>
@endsection

@endif
