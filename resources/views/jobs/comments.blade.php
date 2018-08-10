@extends('layouts.job')

@section('subtitle', __('comment.list'))

@section('content-job')
<div class="row">
    <div class="col-md-8 col-md-offset-1">
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
                    {{ link_to_route('jobs.comments.index', '&times;', [$job] + request(['page']), ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('comment.edit') }}</h4>
                </div>
                {!! Form::model($editableComment, ['route' => ['jobs.comments.update', $job, $editableComment->id],'method' => 'patch']) !!}
                <div class="modal-body">
                    {!! FormField::textarea('body', ['label' => __('comment.body')]) !!}
                    {{ Form::hidden('page', request('page')) }}
                </div>
                <div class="modal-footer">
                    {!! Form::submit(__('comment.update'), ['class' => 'btn btn-success']) !!}
                    {{ link_to_route('jobs.comments.index', __('app.cancel'), [$job] + request(['page']), ['class' => 'btn btn-default']) }}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endif
@endsection

@section('ext_css')
<style>
    ul.pagination { margin-top: 0px }
</style>
@endsection

@section('script')
<script>
(function () {
    $('#commentModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endsection
