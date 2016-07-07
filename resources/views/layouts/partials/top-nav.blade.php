<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            Menu
        </button>
        <a class="navbar-brand" title="Home | {{ Option::get('app_tagline', 'Laravel app description') }}" href="{{ route('home') }}">
            {{ Option::get('app_name', 'Laravel') }}
        </a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> {{ auth()->check() ? auth()->user()->name : 'Guest' }} <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#">{{ auth()->user()->present()->usernameRoles }}</a></li>
                <li><a href="{{ route('auth.profile') }}"><i class="fa fa-user fa-fw"></i> Profil</a></li>
                <li><a href="{{ route('auth.change-password') }}"><i class="fa fa-lock fa-fw"></i> Ganti Password</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
</nav>