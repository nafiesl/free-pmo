@extends('layouts.app')

@section('title', __('job.detail') . ' | ' . $job->name . ' | ' . $job->project->name)

@section('content')
@include('jobs.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        @can('create', new App\Entities\Projects\Job)
            {!! html_link_to_route('projects.jobs.create', __('job.create'), [$job->project_id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
        @endcan
        @can('update', $job)
            {{ link_to_route('jobs.edit', __('job.edit'), [$job], ['class' => 'btn btn-warning']) }}
        @endcan
        {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id, '#' . $job->id], ['class' => 'btn btn-default']) }}
    </div>
    {{ $job->name }} <small>{{ __('job.detail') }}</small>
</h1>
<div class="row">
    <div class="col-md-5">
        @include('jobs.partials.job-show')
    </div>
    <div class="col-sm-7">
        @include('jobs.partials.job-dates')
        @include('jobs.partials.job-tasks-operation')
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @include('jobs.partials.job-tasks')
        @can('view-comments', $job)
        <div class="row">
            <div class="col-md-12">
                {{ $comments->links() }}
                @include('jobs.partials.comment-section')
                {{ $comments->links() }}
            </div>
        </div>

        @if (Request::get('action') == 'comment-edit' && $editableComment)
            <div id="commentModal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            {{ link_to_route('jobs.show', '&times;', [$job] + request(['page']), ['class' => 'close']) }}
                            <h4 class="modal-title">{{ __('comment.edit') }}</h4>
                        </div>
                        {!! Form::model($editableComment, ['route' => ['jobs.comments.update', $job, $editableComment->id],'method' => 'patch']) !!}
                        <div class="modal-body">
                            {!! FormField::textarea('body', ['label' => __('comment.body')]) !!}
                            {{ Form::hidden('page', request('page')) }}
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit(__('comment.update'), ['class' => 'btn btn-success']) !!}
                            {{ link_to_route('jobs.show', __('app.cancel'), [$job] + request(['page']), ['class' => 'btn btn-default']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif
        @endcan
    </div>
</div>
@endsection

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
        ul.pagination { margin-top: 0px }
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

    $('#commentModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endsection
