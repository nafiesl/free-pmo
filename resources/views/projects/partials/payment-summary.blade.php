<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('project.payment_summary') }}</h3></div>
    <table class="table table-condensed">
        <tbody>
            <tr>
                <th class="col-xs-6">{{ trans('project.project_value') }}</th>
                <td class="text-right">{{ formatRp($project->project_value) }}</td>
            </tr>
            <tr>
                <th>{{ trans('project.cash_in_total') }}</th>
                <td class="text-right">{{ formatRp($project->cashInTotal()) }}</td>
            </tr>
            <tr>
                <th>{{ trans('project.cash_out_total') }}</th>
                <td class="text-right">{{ formatRp($project->cashOutTotal()) }}</td>
            </tr>
            <tr>
                <th>{{ trans('project.payment_remaining') }}</th>
                <td class="text-right">{{ formatRp($balance = $project->project_value - $project->cashInTotal()) }}</td>
            </tr>
            <tr>
                <th>{{ trans('project.payment_status') }}</th>
                <td class="text-center">{{ $balance > 0 ? trans('project.payment_statuses.outstanding') : trans('project.payment_statuses.paid') }}</td>
            </tr>
        </tbody>
    </table>
</div>
