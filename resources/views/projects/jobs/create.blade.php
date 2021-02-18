@extends('layouts.project')

@section('subtitle', __('job.create'))

@section('action-buttons')
@can('create', new App\Entities\Projects\Job)
    {!! html_link_to_route('projects.jobs.create', __('job.create'), [$project], ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
    {!! html_link_to_route('projects.jobs.add-from-other-project', __('job.add_from_other_project'), [$project], ['class' => 'btn btn-default', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')

<div class="row">
    <div class="col-sm-6 col-sm-offset-2">
        {{ Form::open(['route' => ['projects.jobs.store', $project]]) }}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('job.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('name', ['label' => __('job.name')]) !!}
                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', [
                            'label'    => __('job.price'),
                            'currency' => Option::get('money_sign', 'Rp'),
                            'value'    => 0,
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('worker_id', $workers, ['label' => __('job.worker'), 'value' => 1]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">{!! FormField::text('target_start_date', ['label' => __('job.target_start_date'), 'class' => 'date-select']) !!}</div>
                    <div class="col-md-4">{!! FormField::text('target_end_date', ['label' => __('job.target_end_date'), 'class' => 'date-select']) !!}</div>
                </div>
            </div>

            <div class="panel-footer">
                {{ Form::submit(__('job.create'), ['class' => 'btn btn-primary']) }}
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection

@section('ext_css')
    {!! Html::style(url('assets/css/plugins/jquery.datetimepicker.css')) !!}
@endsection

@section('script')
{!! Html::script(url('assets/js/plugins/jquery.datetimepicker.js')) !!}
<script>
(function() {
    $('.date-select').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection
