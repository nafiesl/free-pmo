@extends('layouts.app')

@section('title', trans('feature.edit'))

@section('content')
<div class="row"><br>
    <div class="col-md-6">
        {!! Form::model($feature, ['route'=>['features.update', $feature->id], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $feature->name }} <small>{{ trans('feature.edit') }}</small></h3></div>
            <div class="panel-body">
                {!! FormField::text('name',['label'=> trans('feature.name')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', ['label'=> trans('feature.price')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('worker_id', $workers, ['label'=> trans('feature.worker'),'value' => 1]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => 'Project','Tambahan'], ['value' => 1,'label'=> trans('feature.type'),'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                {!! FormField::textarea('description',['label'=> trans('feature.description')]) !!}
            </div>

            <div class="panel-footer">
                {!! Form::hidden('project_id', $feature->project_id) !!}
                {!! Form::submit(trans('feature.update'), ['class'=>'btn btn-primary']) !!}
                {!! link_to_route('features.show', trans('app.show'), [$feature->id], ['class' => 'btn btn-info']) !!}
                {!! link_to_route('projects.features', trans('feature.back_to_index'), [$feature->project_id], ['class' => 'btn btn-default']) !!}
                {!! link_to_route('features.delete', trans('feature.delete'), [$feature->id], ['class'=>'btn btn-danger pull-right']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show', ['project' => $feature->project])
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