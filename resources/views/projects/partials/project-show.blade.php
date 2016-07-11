<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('project.show') }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <tbody>
                <tr><td>{{ trans('project.name') }}</td><td>{{ $project->name }}</td></tr>
                <tr><td>{{ trans('project.description') }}</td><td>{{ $project->description }}</td></tr>
                <tr><td>{{ trans('project.proposal_date') }}</td><td>{{ dateId($project->proposal_date) }}</td></tr>
                <tr><td>{{ trans('project.proposal_value') }}</td><td class="text-right">{{ formatRp($project->proposal_value) }}</td></tr>
                <tr><td>{{ trans('project.project_value') }}</td><td class="text-right">{{ formatRp($project->project_value) }}</td></tr>
                <tr><td>{{ trans('project.start_date') }}</td><td>{{ dateId($project->start_date) }}</td></tr>
                <tr><td>{{ trans('project.end_date') }}</td><td>{{ dateId($project->end_date) }}</td></tr>
                <tr><td>{{ trans('app.status') }}</td><td>{{ $project->present()->status }}</td></tr>
                <tr>
                    <td>{{ trans('project.customer') }}</td>
                    <td>
                        {{ $project->present()->customerNameAndEmail }}
                        @if ($project->customer_id && auth()->id() == $project->owner_id)
                        {!! link_to_route('users.edit', 'Edit', [$project->customer_id], ['title' => 'Edit Data Customer']) !!}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        {!! link_to_route('projects.edit', trans('project.edit'), [$project->id], ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('projects.index', trans('project.back_to_index'), ['status' => $project->status_id], ['class' => 'btn btn-default']) !!}
    </div>
</div>