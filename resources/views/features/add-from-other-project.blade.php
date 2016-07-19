@extends('layouts.app')

@section('title', trans('feature.add_from_other_project'))

@section('content')
@include('projects.partials.breadcrumb',['title' => trans('feature.add_from_other_project')])

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('feature.add_from_other_project') }}</h3></div>
            <div class="panel-body">
                {!! Form::open(['method'=>'get']) !!}
                <?php // echo '<pre>$selectedProject : ', print_r($selectedProject, true), '</pre>'; ?>
                <div class="form-group">
                    <label for="project_id" class="text-primary">{{ trans('project.project') }}</label>
                    <div class="input-group">
                        {!! Form::select('project_id', $projects, Request::get('project_id'), [
                            'class' => 'form-control customer-select',
                            'placeholder' => '-- Pilih Project --'
                        ]) !!}
                        <span class="input-group-btn"><button class="btn btn-default btn-sm" type="submit">Lihat Fitur</button></span>
                    </div>
                </div>
                {!! Form::close() !!}
                @if ($selectedProject)
                {!! Form::open(['route'=>['features.store-from-other-project', $project->id]]) !!}
                <ul class="list-unstyled">
                    @forelse($selectedProject->features as $key => $feature)
                    <li>
                        <label for="feature_id_{{ $feature->id }}">
                        {!! Form::checkbox('feature_ids[' . $feature->id . ']', $feature->id, null, ['id' => 'feature_id_' . $feature->id]) !!}
                        {{ $feature->name }}</label>
                        <ul style="list-style-type:none">
                            @foreach($feature->tasks as $task)
                            <li>
                                <label for="{{ $feature->id }}_task_id_{{ $task->id }}" style="font-weight:normal">
                                {!! Form::checkbox($feature->id . '_task_ids[' . $task->id . ']', $task->id, null, ['id' => $feature->id . '_task_id_' . $task->id]) !!}
                                {{ $task->name }}</label>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @empty
                    <li><div class="alert alert-info">Tidak ada fitur</div></li>
                    @endforelse
                </ul>
                @else
                    <div class="alert alert-info">Pilih salah satu project</div>
                @endif
                {!! Form::submit(trans('feature.create'), ['class'=>'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>

            <div class="panel-footer">
                {!! link_to_route('projects.features', trans('app.cancel'), [$project->id], ['class'=>'btn btn-default']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        @include('projects.partials.project-show')
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