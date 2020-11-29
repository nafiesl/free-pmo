@foreach($comments as $comment)
<div class="alert alert-warning">
    <legend style="font-size: 14px;margin-bottom: 10px;">
        <span class="label label-default pull-right">{{ $comment->time_display }}</span>
        <strong>{{ $comment->creator->name }}</strong>
    </legend>
    <div class="pull-right">
        @can('update', $comment)
            {{ link_to_route('projects.issues.show', __('app.edit'), [$project, $issue, 'action' => 'comment-edit', 'comment_id' => $comment->id], ['id' => 'edit-comment-'.$comment->id, 'class' => 'small', 'title' => __('comment.edit')]) }}
        @endcan
        @can('delete', $comment)
            {!! FormField::delete(
                ['route' => ['issues.comments.destroy', $issue, $comment], 'class' => ''],
                '&times;',
                ['class' => 'btn-link', 'id' => 'delete-comment-'.$comment->id],
                ['comment_id' => $comment->id]
            ) !!}
        @endcan
    </div>
    {!! nl2br($comment->body) !!}
</div>
@endforeach

@can('comment-on', $issue)
{{ Form::open(['route' => ['issues.comments.store', $issue]]) }}
{!! FormField::textarea('body', ['required' => true, 'label' => false, 'placeholder' => __('comment.create_text')]) !!}
{{ Form::submit(__('comment.create'), ['class' => 'btn btn-success pull-right']) }}
{{ Form::close() }}
<div class="clearfix"></div><br>
@endcan

@if (Request::get('action') == 'comment-edit' && $editableComment)
    <div id="commentModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    {{ link_to_route('projects.issues.show', '&times;', [$issue->project, $issue], ['class' => 'close']) }}
                    <h4 class="modal-title">{{ __('comment.edit') }}</h4>
                </div>
                {!! Form::model($editableComment, ['route' => ['issues.comments.update', $issue, $editableComment], 'method' => 'patch']) !!}
                <div class="modal-body">
                    {!! FormField::textarea('body', ['label' => __('comment.body')]) !!}
                    {{ Form::hidden('page', request('page')) }}
                </div>
                <div class="modal-footer">
                    {!! Form::submit(__('comment.update'), ['class' => 'btn btn-success']) !!}
                    {{ link_to_route('projects.issues.show', __('app.cancel'), [$project, $issue] + request(['page']), ['class' => 'btn btn-default']) }}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endif
