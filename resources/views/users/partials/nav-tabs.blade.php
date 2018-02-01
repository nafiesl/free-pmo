<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('users.show', trans('user.profile'), [$user]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'jobs' ? 'active' : '' }}">
        @php
            $onProgressJobsCount = AdminDashboard::onProgressJobCount($user);
        @endphp
        {!! link_to_route(
            'users.jobs',
            trans('user.jobs').' ('.$onProgressJobsCount.')',
            [$user],
            ['title' => $onProgressJobsCount.' '.trans('user.current_jobs')]
        ) !!}
    </li>
    <li class="{{ Request::segment(3) == 'projects' ? 'active' : '' }}">
        {!! link_to_route('users.projects', trans('user.projects'), [$user]) !!}
    </li>
</ul>
<br>
