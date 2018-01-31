<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('users.show', trans('user.profile'), [$user]) !!}
    </li>
</ul>
<br>
