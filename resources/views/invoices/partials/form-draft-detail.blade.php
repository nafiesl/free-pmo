<legend>{{ trans('invoice.detail') }}</legend>
{{ Form::open(['route' => ['cart.draft-proccess', $draft->draftKey], 'method' => 'patch']) }}
{!! FormField::select('project_id', $projects, ['label' => trans('invoice.project'), 'required' => true]) !!}
{!! FormField::textarea('notes', ['label' => trans('invoice.notes'), 'value' => $draft->notes]) !!}
{{ Form::submit(trans('invoice.proccess'), ['class' => 'btn btn-info']) }}
{{ Form::close() }}