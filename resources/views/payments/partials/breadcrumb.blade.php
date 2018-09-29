<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('projects.index',__('project.projects')) }}</li>
    <li>{{ $payment->present()->projectLink }}</li>
    <li>{{ $payment->present()->projectPaymentsLink }}</li>
    <li class="active">{{ isset($title) ? $title : __('payment.detail') }}</li>
</ul>
