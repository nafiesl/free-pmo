<ul class="breadcrumb hidden-print">
    <li>{{ link_to_route('users.index',trans('user.list')) }}</li>
    <li>{{ $user->nameLink() }}</li>
    <li class="active">@yield('subtitle', trans('user.profile'))</li>
</ul>
