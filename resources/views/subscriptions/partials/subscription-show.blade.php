<table class="table table-condensed">
    <tbody>
        <tr><td>{{ __('subscription.name') }}</td><td>{{ $subscription->name }}</td></tr>
        <tr><td>{{ __('subscription.price') }}</td><td>{{ format_money($subscription->price) }}</td></tr>
        <tr><td>{{ __('subscription.type') }}</td><td>{{ $subscription->type }}</td></tr>
        <tr><td>{{ __('subscription.start_date') }}</td><td>{{ date_id($subscription->start_date) }}</td></tr>
        <tr><td>{{ __('subscription.due_date') }}</td><td>{{ date_id($subscription->due_date) }}</td></tr>
        <tr><td>{{ __('subscription.customer') }}</td><td>{{ $subscription->customer->nameLink() }}</td></tr>
        <tr>
            <td>{{ __('subscription.project') }}</td>
            <td>
                {{ link_to_route('projects.subscriptions', $subscription->project->name, [$subscription->project_id]) }}
            </td>
        </tr>
        <tr><td>{{ __('subscription.vendor') }}</td><td>{{ $subscription->vendor->name }}</td></tr>
        <tr><td>{{ __('subscription.notes') }}</td><td>{!! nl2br($subscription->notes) !!}</td></tr>
    </tbody>
</table>
