<div class="hidden-print" style="padding:10px 10px;vertical-align:middle">
    @if (auth()->user())
    <div class="pull-right hidden-xs" style="position: absolute; left: auto; right: 0;">
        <div class="panel panel-warning text-center">
            <div class="panel-heading" style="margin:auto 0">
                User: {{ auth()->user()->present()->usernameRoles }}
                <br>
                <a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
            </div>
        </div>
    </div>
    @endif
    <a class="logo-brand" title="{{ Option::get('app_name', 'Aplikasi Laravel') }}" href="{{ route('home') }}">
        <img src="{{ url('assets/imgs/logo.png') }}" alt="Logo {{ Option::get('app_name', 'Aplikasi Laravel') }}" width="60px">
        <h1>{{ Option::get('app_name', 'Aplikasi Laravel') }} <br><small>{{ Option::get('app_tagline', 'Tagline Aplikasi Laravel') }}</small></h1>
    </a>
</div>

<nav class="navbar navbar-default hidden-md" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            Menu
        </button>
    </div>
</nav>