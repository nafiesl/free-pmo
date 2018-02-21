<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('projects.show', trans('project.show'), [$project->id]) !!}
    </li>
    @can('view-jobs', $project)
    <li class="{{ Request::segment(3) == 'jobs' ? 'active' : '' }}">
        {!! link_to_route('projects.jobs.index', trans('project.jobs').' ('.$project->jobs->count().')', [$project->id]) !!}
    </li>
    @endcan
    @can('view-payments', $project)
    <li class="{{ Request::segment(3) == 'payments' ? 'active' : '' }}">
        {!! link_to_route('projects.payments', trans('project.payments').' ('.$project->payments->count().')', [$project->id]) !!}
    </li>
    @endcan
    @can('view-subscriptions', $project)
    <li class="{{ Request::segment(3) == 'subscriptions' ? 'active' : '' }}">
        {!! link_to_route('projects.subscriptions', trans('project.subscriptions').' ('.$project->subscriptions->count().')', [$project->id]) !!}
    </li>
    @endcan
    @can('view-invoices', $project)
    <li class="{{ Request::segment(3) == 'invoices' ? 'active' : '' }}">
        {!! link_to_route('projects.invoices', trans('project.invoices').' ('.$project->invoices->count().')', [$project->id]) !!}
    </li>
    @endcan
    @can('view-files', $project)
    <li class="{{ Request::segment(3) == 'files' ? 'active' : '' }}">
        {!! link_to_route('projects.files', trans('project.files').' ('.$project->files->count().')', [$project->id]) !!}
    </li>
    @endcan
</ul>
<br>
