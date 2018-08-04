{{ Form::open(['route' => ['projects.comments.store', $project]]) }}
<div class="row">
    <div class="col-md-9">{!! FormField::textarea('body', ['required' => true, 'label' => false, 'placeholder' => __('comment.create_text')]) !!}</div>
    <div class="col-md-3">
        {{ Form::submit(__('comment.create'), ['class' => 'btn btn-success btn-block']) }}<br>
    </div>
</div>
{{ Form::close() }}
@foreach($comments as $comment)
<div class="alert alert-warning">
    <legend style="font-size: 14px;margin-bottom: 10px;">
        <span class="label label-default pull-right">{{ $comment->created_at }}</span>
        <strong>{{ $comment->creator->name }}</strong>
    </legend>

    {!! nl2br($comment->body) !!}
</div>
@endforeach
