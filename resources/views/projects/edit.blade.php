@extends('layouts.app')

@section('title', trans('project.edit'))

@section('content')

@include('projects.partials.breadcrumb',['title' => trans('project.edit')])

<div class="row">
    <div class="col-md-7 col-md-offset-2">
        {!! Form::model($project, ['route'=>['projects.update', $project->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $project->name }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name',['label'=> trans('project.name')]) !!}
                {!! FormField::textarea('description',['label'=> trans('project.description'),'rows' => 3]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('proposal_date',['label'=> trans('project.proposal_date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('proposal_value', ['label'=> trans('project.proposal_value')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        {!! FormField::text('start_date',['label'=> trans('project.start_date')]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! FormField::text('end_date',['label'=> trans('project.end_date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('project_value', ['label'=> trans('project.project_value')]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => trans('app.status')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::select('customer_id', $customers, ['label' => trans('project.customer')]) !!}
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                {!! Form::submit(trans('project.update'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('projects.show', trans('app.show'), [$project->id], ['class' => 'btn btn-info']) !!}
                {!! link_to_route('projects.index', trans('project.back_to_index'), ['status' => $project->status_id], ['class' => 'btn btn-default']) !!}
                {!! link_to_route('projects.delete', trans('app.delete'), [$project->id], ['class'=>'btn btn-danger pull-right']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) !!}
@endsection

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery.datetimepicker.js')) !!}
@endsection

@section('script')
<script>
(function() {
    $('#proposal_date,#start_date,#end_date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true
    });
})();
</script>
@endsection