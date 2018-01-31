<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('users.show', trans('user.profile'), [$user]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'jobs' ? 'active' : '' }}">
        {!! link_to_route('users.jobs', trans('user.jobs').' ('.$user->jobs()->count().')', [$user]) !!}
    </li>
</ul>
<br>
