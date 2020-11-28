<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('subscriptions.index',__('subscription.list')) }}</li>
    <li>{{ $subscription->name_link }}</li>
    <li class="active">{{ isset($title) ? $title : __('subscription.detail') }}</li>
</ul>
