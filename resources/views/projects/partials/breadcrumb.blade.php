<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('projects.index',__('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
    <li>{{ link_to_route('projects.show', $project->name, $project) }}</li>
    <li class="active">@yield('subtitle', __('project.detail'))</li>
</ul>
