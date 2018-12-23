<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">{{ trans('project.project_value') }}</td>
            <td class="col-xs-2 text-center">{{ trans('project.cash_in_total') }}</td>
            <td class="col-xs-2 text-center">{{ trans('project.cash_out_total') }}</td>
            <td class="col-xs-2 text-center">{{ trans('project.payment_remaining') }}</td>
            <td class="col-xs-2 text-center">{{ trans('project.payment_status') }}</td>
        </tr>
        <tr>
            <td class="text-center lead" style="border-top: none;">{{ format_money($project->project_value) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ format_money($project->cashInTotal()) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ format_money($project->cashOutTotal()) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ format_money($balance = $project->project_value - $project->cashInTotal()) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $balance > 0 ? trans('project.payment_statuses.outstanding') : trans('project.payment_statuses.paid') }}</td>
        </tr>
    </table>
</div>

<ul class="list-group visible-xs">
    <li class="list-group-item">{{ trans('project.project_value') }} <span class="pull-right">{{ format_money($project->project_value) }}</span></li>
    <li class="list-group-item">{{ trans('project.cash_in_total') }} <span class="pull-right">{{ format_money($project->cashInTotal()) }}</span></li>
    <li class="list-group-item">{{ trans('project.cash_out_total') }} <span class="pull-right">{{ format_money($project->cashOutTotal()) }}</span></li>
    <li class="list-group-item">{{ trans('project.payment_remaining') }} <span class="pull-right">{{ format_money($balance = $project->project_value - $project->cashInTotal()) }}</span></li>
    <li class="list-group-item">{{ trans('project.payment_status') }} <span class="pull-right">{{ $balance > 0 ? trans('project.payment_statuses.outstanding') : trans('project.payment_statuses.paid') }}</span></li>
</ul>
