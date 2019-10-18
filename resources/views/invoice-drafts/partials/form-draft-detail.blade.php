<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.detail') }}</h3></div>
    {{ Form::open(['route' => ['invoice-drafts.draft-proccess', $draft->draftKey], 'method' => 'patch']) }}
    <div class="panel-body">
        @php
            $project = App\Entities\Projects\Project::find($draft->projectId);
        @endphp
        @if (!is_null($project))
        {!! FormField::textDisplay(trans('project.project'), $project->name) !!}
        {!! FormField::textDisplay(trans('project.customer'), $project->customer->name) !!}
        {{ Form::hidden('project_id', $project->id) }}
        @else
        {!! FormField::select('project_id', $projects, [
            'label' => trans('invoice.project'),
            'value' => $draft->projectId,
            'required' => true,
        ]) !!}
        @endif
        <div class="row">
            <div class="col-md-6">
                {!! FormField::text('date', [
                    'placeholder' => 'yyyy-mm-dd',
                    'label' => trans('invoice.date'),
                    'value' => $draft->date ?: now()->format('Y-m-d'),
                ]) !!}
            </div>
            <div class="col-md-6">
                {!! FormField::text('due_date', [
                    'placeholder' => 'yyyy-mm-dd',
                    'label' => trans('invoice.due_date'),
                    'value' => $draft->dueDate,
                ]) !!}
            </div>
        </div>
        {!! FormField::textarea('notes', ['label' => trans('invoice.notes'), 'value' => $draft->notes]) !!}
    </div>
    <div class="panel-footer">
        {{ Form::submit(trans('invoice.proccess'), ['class' => 'btn btn-info']) }}
    </div>
    {{ Form::close() }}
</div>
