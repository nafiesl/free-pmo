@if (Request::segment(3) == 'features')
{!! link_to_route('projects.features-export', trans('project.features_export'), [$project->id], ['class' => 'btn btn-success pull-right']) !!}
@endif
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('projects.show', trans('project.show'), [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'features' ? 'active' : '' }}">
        {!! link_to_route('projects.features', trans('project.features') . ' (' . $project->features->count() . ')', [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'payments' ? 'active' : '' }}">
        {!! link_to_route('projects.payments', trans('project.payments') . ' (' . $project->payments->count() . ')', [$project->id]) !!}
    </li>
</ul>
<br>