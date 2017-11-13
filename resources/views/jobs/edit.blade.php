@extends('layouts.app')

@section('title', trans('job.edit'))

@section('content')
<div class="row"><br>
    <div class="col-md-6">
        {!! Form::model($job, ['route'=>['jobs.update', $job->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $job->name }} <small>{{ trans('job.edit') }}</small></h3></div>
            <div class="panel-body">
                {!! FormField::text('name',['label'=> trans('job.name')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', ['label'=> trans('job.price')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('worker_id', $workers, ['label'=> trans('job.worker'),'value' => 1]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => 'Project','Tambahan'], ['value' => 1,'label'=> trans('job.type'),'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                {!! FormField::textarea('description',['label'=> trans('job.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::hidden('project_id', $job->project_id) !!}
                {!! Form::submit(trans('job.update'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('jobs.show', trans('app.show'), [$job->id], ['class' => 'btn btn-info']) !!}
                {!! link_to_route('projects.jobs', trans('job.back_to_index'), [$job->project_id], ['class' => 'btn btn-default']) !!}
                {!! link_to_route('jobs.delete', trans('job.delete'), [$job->id], ['class'=>'btn btn-danger pull-right']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show', ['project' => $job->project])
    </div>
</div>
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/autoNumeric.min.js')) !!}
@endsection

@section('script')
<script>
(function() {
    $('#price').autoNumeric("init",{
        aSep: '.',
        aDec: ',',
        mDec: '0'
    });
})();
</script>
@endsection
