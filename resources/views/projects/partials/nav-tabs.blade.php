@if (Request::segment(3) == 'features')
<div class="pull-right">
{!! link_to_route('projects.features-export', trans('project.features_export_html'), [$project->id, 'html'], ['class' => 'btn btn-link','target' => '_blank']) !!}
{!! link_to_route('projects.features-export', trans('project.features_export_excel'), [$project->id], ['class' => 'btn btn-link']) !!}
</div>
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