<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('projects.index',trans('project.projects')) }}</li>
    <li>{{ $project->present()->projectLink }}</li>
    <li class="active">{{ isset($title) ? $title : trans('project.show') }}</li>
</ul>