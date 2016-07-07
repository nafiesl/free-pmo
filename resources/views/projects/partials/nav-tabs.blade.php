<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('projects.show', trans('project.show'), [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'features' ? 'active' : '' }}">
        {!! link_to_route('projects.features', trans('project.features'), [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'payments' ? 'active' : '' }}">
        {!! link_to_route('projects.payments', trans('project.payments'), [$project->id]) !!}
    </li>
</ul>
<br>