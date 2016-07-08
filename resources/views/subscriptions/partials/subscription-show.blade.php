<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('subscription.show') }}</h3></div>
    <table class="table table-condensed">
        <tbody>
            <tr><td>{{ trans('subscription.project') }}</td><td>{{ $subscription->project->name }}</td></tr>
            <tr><td>{{ trans('subscription.domain_name') }}</td><td>{{ $subscription->domain_name }}</td></tr>
            <tr><td>{{ trans('subscription.domain_price') }}</td><td>{{ formatRp($subscription->domain_price) }}</td></tr>
            <tr><td>{{ trans('subscription.epp_code') }}</td><td>{{ $subscription->epp_code }}</td></tr>
            <tr><td>{{ trans('subscription.hosting_capacity') }}</td><td>{{ $subscription->hosting_capacity }}</td></tr>
            <tr><td>{{ trans('subscription.hosting_price') }}</td><td>{{ formatRp($subscription->hosting_price) }}</td></tr>
            <tr><td>{{ trans('subscription.start_date') }}</td><td>{{ dateId($subscription->start_date) }}</td></tr>
            <tr><td>{{ trans('subscription.due_date') }}</td><td>{{ dateId($subscription->due_date) }}</td></tr>
            <tr>
                <td>{{ trans('subscription.customer') }}</td>
                <td>
                    {{ $subscription->present()->customerNameAndEmail }}
                    @if ($subscription->project->customer_id && auth()->id() == $subscription->project->owner_id)
                    {!! link_to_route('users.edit', 'Edit', [$subscription->customer_id], ['title' => 'Edit Data Customer']) !!}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <div class="panel-footer">
        {!! link_to_route('subscriptions.edit', trans('subscription.edit'), [$subscription->id], ['class' => 'btn btn-warning']) !!}
        {!! link_to_route('subscriptions.index', trans('subscription.back_to_index'), [], ['class' => 'btn btn-default']) !!}
    </div>
</div>