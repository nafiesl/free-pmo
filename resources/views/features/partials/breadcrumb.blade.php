<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('projects.index',trans('project.projects')) }}</li>
    <li>{{ $feature->present()->projectLink }}</li>
    <li>{{ $feature->present()->projectFeaturesLink }}</li>
    <li class="active">{{ isset($title) ? $title : $feature->name }}</li>
</ul>