<nav class="navbar navbar-default hidden-md" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            Menu
        </button>
    </div>
</nav>
<div class="navbar-default sidebar hidden-print" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <a class="navbar-brand text-center" title="Home | {{ Option::get('app_tagline', 'Laravel app description') }}" href="{{ route('home') }}">
            {!! Html::image(url('assets/imgs/logo.png'),'Logo ' . Option::get('app_name','Laravel'), ['class' => 'sidebar-logo']) !!}
        </a>
        <ul class="nav" id="side-menu">
            <li>{!! html_link_to_route('home', 'Dashboard', [], ['icon' => 'dashboard']) !!}</li>
            @can('add_project')
            <li>{!! html_link_to_route('features.index', 'On Progress Features', [], ['icon' => 'tasks']) !!}</li>
            <li>
                <?php $projectsCount = App\Entities\Projects\Project::select(DB::raw('status_id, count(id) as count'))
                            ->groupBy('status_id')
                            ->where('owner_id', auth()->id())
                            ->lists('count','status_id')
                            ->all(); ?>
                {!! html_link_to_route('projects.index', trans('project.projects') . ' <span class="fa arrow"></span>', [], ['icon' => 'table']) !!}
                <ul class="nav nav-second-level">
                    @foreach(getProjectStatusesList() as $key => $status)
                    <li>
                        <a href="{{ route('projects.index', ['status' => $key]) }}">
                            {{ $status }}
                            <span class="badge pull-right">{{ array_key_exists($key, $projectsCount) ? $projectsCount[$key] : 0 }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endcan
            @can('see_reports')
            <li>{!! html_link_to_route('reports.payments.yearly', 'Penghasilan', [], ['icon' => 'line-chart']) !!}</li>
            <li>{!! html_link_to_route('reports.current-credits', 'Piutang', [], ['icon' => 'money']) !!}</li>
            <li>{!! html_link_to_route('users.calendar', 'Calendar', [], ['icon' => 'calendar']) !!}</li>
            {{--
            <li>
                {!! html_link_to_route('reports.payments.index', 'Laporan <span class="fa arrow"></span>', [], ['icon' => 'line-chart']) !!}
                <ul class="nav nav-second-level">
                    <li>
                        {!! html_link_to_route('reports.payments.index', 'Pembayaran <span class="fa arrow"></span>') !!}
                        <ul class="nav nav-third-level">
                            <li>{!! link_to_route('reports.payments.yearly', 'Tahunan') !!}</li>
                            <li>{!! link_to_route('reports.payments.monthly', 'Bulanan') !!}</li>
                            <li>{!! link_to_route('reports.payments.daily', 'Harian') !!}</li>
                        </ul>
                    </li>
                    <li>{!! html_link_to_route('reports.current-credits', 'Piutang') !!}</li>
                </ul>
            </li>
            --}}
            @endcan
            @can('manage_subscriptions')
            <li>{!! html_link_to_route('subscriptions.index', trans('subscription.subscription'), [], ['icon' => 'retweet']) !!}</li>
            @endcan
            @can('manage_payments')
            <li>{!! html_link_to_route('payments.index', trans('payment.payments'), [], ['icon' => 'money']) !!}</li>
            @endcan
            @can('manage_users')
            <li>
                <a href="{{ route('users.index') }}"><i class="fa fa-users fa-fw"></i> {{ trans('user.users') }} <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('users.index') }}"><i class="fa fa-users fa-fw"></i> {{ trans('user.users') }}</a></li>
                    @can('manage_role_permissions')
                    <li><a href="{{ route('roles.index') }}"><i class="fa fa-gears fa-fw"></i> {{ trans('role.roles') }}</a></li>
                    <li><a href="{{ route('permissions.index') }}"><i class="fa fa-lock fa-fw"></i> {{ trans('permission.permissions') }}</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('manage_options')
            <li>
                <a href="{{ route('options.index') }}"><i class="fa fa-gears fa-fw"></i> Options <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @can('manage_options')
                    <li><a href="{{ route('options.index') }}"><i class="fa fa-gears fa-fw"></i> Options</a></li>
                    @endcan
                    @can('manage_backups')
                    <li><a href="{{ route('backups.index') }}"><i class="fa fa-refresh fa-fw"></i> Backup/Restore DB</a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            <li><a href="{{ route('auth.change-password') }}"><i class="fa fa-lock fa-fw"></i> {{ trans('auth.change_password') }}</a></li>
            <li><a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out fa-fw"></i> {{ trans('auth.logout') }}</a></li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->

