<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('projects.index', __('project.projects')) }}</li>
    <li>{{ $job->present()->projectLink }}</li>
    <li>{{ $job->present()->projectJobsLink }}</li>
    <li class="active">{{ isset($title) ? $title : $job->name }}</li>
</ul>
