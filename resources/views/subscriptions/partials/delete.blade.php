<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('subscription.delete') }}</h3></div>
            @include('subscriptions.partials.subscription-show')
            <div class="panel-body">
                {{ __('app.delete_confirm') }}
            </div>
            <div class="panel-footer">
                {!! link_to_route('subscriptions.edit', __('app.cancel'), [$subscription->id], ['class' => 'btn btn-default']) !!}
                {!! FormField::delete(
                    ['route' => ['subscriptions.destroy', $subscription->id]],
                    __('app.delete_confirm_button'),
                    ['class' => 'btn btn-danger'],
                    ['subscription_id' => $subscription->id]
                ) !!}
            </div>
        </div>
    </div>
</div>
