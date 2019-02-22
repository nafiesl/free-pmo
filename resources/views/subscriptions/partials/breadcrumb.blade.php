<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('subscriptions.index',trans('subscription.list')) }}</li>
    <li>{{ $subscription->name_link }}</li>
    <li class="active">{{ isset($title) ? $title : trans('subscription.detail') }}</li>
</ul>
