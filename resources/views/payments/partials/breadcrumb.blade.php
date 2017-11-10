<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('projects.index',trans('project.projects')) }}</li>
    <li>{{ $payment->present()->projectLink }}</li>
    <li>{{ $payment->present()->projectPaymentsLink }}</li>
    <li class="active">{{ isset($title) ? $title : trans('payment.detail') }}</li>
</ul>
