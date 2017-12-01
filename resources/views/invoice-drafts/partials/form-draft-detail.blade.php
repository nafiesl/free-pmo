<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.detail') }}</h3></div>
    {{ Form::open(['route' => ['invoice-drafts.draft-proccess', $draft->draftKey], 'method' => 'patch']) }}
    <div class="panel-body">
        {!! FormField::select('project_id', $projects, [
            'label' => trans('invoice.project'),
            'value' => $draft->projectId,
            'required' => true,
        ] ) !!}
        {!! FormField::textarea('notes', ['label' => trans('invoice.notes'), 'value' => $draft->notes]) !!}
    </div>
    <div class="panel-footer">
        {{ Form::submit(trans('invoice.proccess'), ['class' => 'btn btn-info']) }}
    </div>
    {{ Form::close() }}
</div>
