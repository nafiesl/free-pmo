@php
    $queryStrings = request(['q']);
    $routeName = $routeName ?? 'projects.index';
@endphp
<!-- Nav tabs -->
<ul class="nav nav-pills">
    <li class="{{ request('status_id') == null ? 'active' : '' }}">
        {{ link_to_route($routeName, __('project.all'), $queryStrings, ['title' => __('project.all')]) }}
    </li>
    <li class="{{ request('status_id') == 1 ? 'active' : '' }}">
        {{ link_to_route($routeName, __('project.planned'), ['status_id' => 1] + $queryStrings, ['title' => __('project.planned')]) }}
    </li>
    <li class="{{ request('status_id') == 2 ? 'active' : '' }}">
        {{ link_to_route($routeName, __('project.progress'), ['status_id' => 2] + $queryStrings, ['title' => __('project.progress')]) }}
    </li>
    <li class="{{ request('status_id') == 3 ? 'active' : '' }}">
        {{ link_to_route($routeName, __('project.done'), ['status_id' => 3] + $queryStrings, ['title' => __('project.done')]) }}
    </li>
    <li class="{{ request('status_id') == 4 ? 'active' : '' }}">
        {{ link_to_route($routeName, __('project.closed'), ['status_id' => 4] + $queryStrings, ['title' => __('project.closed')]) }}
    </li>
    <li class="{{ request('status_id') == 5 ? 'active' : '' }}">
        {{ link_to_route($routeName, __('project.canceled'), ['status_id' => 5] + $queryStrings, ['title' => __('project.canceled')]) }}
    </li>
    <li class="{{ request('status_id') == 6 ? 'active' : '' }}">
        {{ link_to_route($routeName, __('project.on_hold'), ['status_id' => 6] + $queryStrings, ['title' => __('project.on_hold')]) }}
    </li>
</ul>
