@foreach($comments as $comment)
<div class="alert alert-warning">
    <legend style="font-size: 14px;margin-bottom: 10px;">
        <span class="label label-default pull-right">{{ $comment->time_display }}</span>
        <strong>{{ $comment->creator->name }}</strong>
    </legend>
    {!! nl2br($comment->body) !!}
</div>
@endforeach

{{ Form::open(['route' => ['issues.comments.store', $issue]]) }}
{!! FormField::textarea('body', ['required' => true, 'label' => false, 'placeholder' => __('comment.create_text')]) !!}
{{ Form::submit(__('comment.create'), ['class' => 'btn btn-success pull-right']) }}
{{ Form::close() }}
<div class="clearfix"></div><br>
