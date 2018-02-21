<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(1) == 'home' ? 'active' : '' }}">
        {!! link_to_route('home', trans('nav_menu.dashboard')) !!}
    </li>
    <li class="{{ Request::segment(1) == 'profile' ? 'active' : '' }}">
        {!! link_to_route('users.profile.show', trans('auth.profile')) !!}
    </li>
        <li class="{{ Request::segment(1) == 'agency' ? 'active' : '' }}">
            {!! link_to_route('users.agency.show', trans('nav_menu.agency')) !!}
        </li>
    @can('manage_agency')
        <li class="{{ Request::segment(1) == 'users' ? 'active' : '' }}">
            {!! link_to_route('users.index', trans('user.list')) !!}
        </li>
        <li class="{{ Request::segment(1) == 'bank-accounts' ? 'active' : '' }}">
            {!! link_to_route('bank-accounts.index', trans('bank_account.list')) !!}
        </li>
        <li class="{{ Request::segment(1) == 'site-options' ? 'active' : '' }}">
            {!! link_to_route('site-options.page-1', trans('option.list')) !!}
        </li>
    @endcan
</ul>
<br>
