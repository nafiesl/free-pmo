@extends('layouts.project')

@section('subtitle', __('job.create'))

@section('action-buttons')
@can('create', new App\Entities\Projects\Job)
    {!! html_link_to_route('projects.jobs.create', __('job.create'), [$project->id], ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
    {!! html_link_to_route('projects.jobs.add-from-other-project', __('job.add_from_other_project'), [$project->id], ['class' => 'btn btn-default', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')

<div class="row">
    <div class="col-sm-6 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('job.add_from_other_project') }}</h3></div>
            <div class="panel-body">
                {{ Form::open(['method' => 'get', 'class' => 'form-inline', 'style' => 'margin-bottom:20px']) }}
                {!! FormField::select('project_id', $projects, [
                    'label' => false,
                    'value' => request('project_id'),
                    'placeholder' => __('project.select'),
                ]) !!}
                {{ Form::submit(__('project.show_jobs'), ['class' => 'btn btn-default btn-sm']) }}
                {{ Form::close() }}
                @if ($selectedProject)
                {{ Form::open(['route' => ['projects.jobs.store-from-other-project', $project->id]]) }}
                <ul class="list-unstyled">
                    @forelse($selectedProject->jobs as $key => $job)
                    <li>
                        <label for="job_id_{{ $job->id }}">
                        {{ Form::checkbox('job_ids['.$job->id.']', $job->id, null, ['id' => 'job_id_'.$job->id]) }}
                        {{ $job->name }}</label>
                        <ul style="list-style-type:none">
                            @foreach($job->tasks as $task)
                            <li>
                                <label for="{{ $job->id }}_task_id_{{ $task->id }}" style="font-weight:normal">
                                {{ Form::checkbox($job->id.'_task_ids['.$task->id.']', $task->id, null, ['id' => $job->id.'_task_id_'.$task->id, 'class' => 'job_id_'.$job->id.'_tasks']) }}
                                {{ $task->name }}</label>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @empty
                    <li><div class="alert alert-info">{{ __('job.not_found') }}</div></li>
                    @endforelse
                </ul>
                @else
                    <div class="alert alert-info">{{ __('job.select_project') }}</div>
                @endif
                @if ($errors->has('job_ids'))
                    <div class="alert alert-danger">{{ __('validation.select_one') }}</div>
                @endif
                {{ Form::submit(__('job.add'), ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}
            </div>

            <div class="panel-footer">
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('ext_css')
    {{ Html::style(url('assets/css/plugins/select2.min.css')) }}
    <style>
    .select2-selection.select2-selection--single {
        border-radius: 0;
        height: 30px;
    }
    </style>
@endsection

@section('script')
{{ Html::script(url('assets/js/plugins/select2.min.js')) }}
<script>
(function() {
    $('select[name=project_id]').select2();

    @if ($selectedProject)
        @foreach ($selectedProject->jobs as $job)

            $('#job_id_{{ $job->id }}').change(function () {
                $('.job_id_{{ $job->id }}_tasks').prop('checked', this.checked);
            });

            @foreach($job->tasks as $task)

                $('#{{ $job->id }}_task_id_{{ $task->id }}').change(function () {

                    var condition = false;

                    $.each($(".job_id_{{ $job->id }}_tasks"), function( key, value ) {
                        if(value.checked == true){
                            condition = true
                        }
                    });


                    if(condition == true){
                        $('#job_id_{{ $job->id }}').prop('checked', true);
                    }
                });

            @endforeach

        @endforeach
    @endif
})();
</script>
@endsection
