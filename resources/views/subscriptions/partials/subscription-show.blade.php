<table class="table table-condensed">
    <tbody>
        <tr><td>{{ trans('subscription.name') }}</td><td>{{ $subscription->name }}</td></tr>
        <tr><td>{{ trans('subscription.price') }}</td><td>{{ formatRp($subscription->price) }}</td></tr>
        <tr><td>{{ trans('subscription.type') }}</td><td>{{ $subscription->type }}</td></tr>
        <tr><td>{{ trans('subscription.start_date') }}</td><td>{{ dateId($subscription->start_date) }}</td></tr>
        <tr><td>{{ trans('subscription.due_date') }}</td><td>{{ dateId($subscription->due_date) }}</td></tr>
        <tr><td>{{ trans('subscription.customer') }}</td><td>{{ $subscription->customer->nameLink() }}</td></tr>
        <tr>
            <td>{{ trans('subscription.project') }}</td>
            <td>
                {{ link_to_route('projects.subscriptions', $subscription->project->name, [$subscription->project_id]) }}
            </td>
        </tr>
        <tr><td>{{ trans('subscription.notes') }}</td><td>{!! nl2br($subscription->notes) !!}</td></tr>
    </tbody>
</table>
