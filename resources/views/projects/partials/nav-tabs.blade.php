@if (Request::segment(3) == 'features')
<div class="pull-right">
{!! link_to_route('projects.features-export', trans('project.features_export_html'), [$project->id, 'html', 'feature_type' => Request::get('feature_type', 1)], ['class' => 'btn btn-link','target' => '_blank']) !!}
{!! link_to_route('projects.features-export', trans('project.features_export_excel'), [$project->id, 'excel', 'feature_type' => Request::get('feature_type', 1)], ['class' => 'btn btn-link']) !!}
</div>
@endif
<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('projects.show', trans('project.show'), [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'features' && Request::has('feature_type') == false ? 'active' : '' }}">
        {!! link_to_route('projects.features', trans('project.features') . ' (' . $project->features->count() . ')', [$project->id]) !!}
    </li>
    @if ($project->additionalFeatures->count())
    <li class="{{ Request::segment(3) == 'features' && Request::has('feature_type') ? 'active' : '' }}">
        {!! link_to_route('projects.features', trans('project.features') . ' Tambahan (' . $project->additionalFeatures->count() . ')', [$project->id, 'feature_type' => 2]) !!}
    </li>
    @endif
    <li class="{{ Request::segment(3) == 'payments' ? 'active' : '' }}">
        {!! link_to_route('projects.payments', trans('project.payments') . ' (' . $project->payments->count() . ')', [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'subscriptions' ? 'active' : '' }}">
        {!! link_to_route('projects.subscriptions', trans('project.subscriptions'), [$project->id]) !!}
    </li>
</ul>
<br>