@extends('layouts.dashboard')

@section('title', trans('nav_menu.dashboard'))

@section('content-dashboard')

<div class="row">
    <div class="col-lg-5">
        <legend style="border-bottom: none" class="text-center">{{ trans('dashboard.project_status_stats') }}</legend>
        <div class="row">
            @foreach(ProjectStatus::all() as $statusId => $status)
            <div class="col-lg-6 col-md-4 col-xs-6">
                @include('view-components.dashboard-panel', [
                    'class' => ProjectStatus::getColorById($statusId),
                    'icon' => ProjectStatus::getIconById($statusId),
                    'number' => array_key_exists($statusId, $projectStatusStats) ? $projectStatusStats[$statusId] : 0,
                    'text' => ProjectStatus::getNameById($statusId),
                    'linkRoute' => route('projects.index', ['status' => $statusId]),
                ])
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-7">
        <legend style="border-bottom: none" class="text-center">{{ trans('dashboard.earnings_stats') }}</legend>
        <div class="panel panel-default table-responsive hidden-xs">
            <table class="table table-condensed table-bordered">
                <tr>
                    <td class="col-xs-2 text-center">{{ trans('dashboard.yearly_earnings') }} ({{ $queriedYear }})</td>
                    <td class="col-xs-2 text-center">{{ trans('dashboard.finished_projects_count') }} ({{ $queriedYear }})</td>
                    <td class="col-xs-2 text-center">{{ trans('dashboard.receiveable_earnings') }}</td>
                </tr>
                <tr>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $totalEarnings = formatRp(AdminDashboard::totalEarnings($queriedYear)) }}
                    </td>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $totalFinishedProjects = AdminDashboard::totalFinishedProjects($queriedYear) }} Projects
                    </td>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $currentOutstandingCustomerPayment = formatRp(AdminDashboard::currentOutstandingCustomerPayment($queriedYear)) }}
                    </td>
                </tr>
            </table>
        </div>

        <ul class="list-group visible-xs">
            <li class="list-group-item">
                {{ trans('dashboard.yearly_earnings') }} ({{ $queriedYear }})
                <span class="pull-right text-primary">{{ $totalEarnings }}</span>
            </li>
            <li class="list-group-item">
                {{ trans('dashboard.finished_projects_count') }} ({{ $queriedYear }})
                <span class="pull-right text-primary">{{ $totalFinishedProjects }} Projects</span>
            </li>
            <li class="list-group-item">
                {{ trans('dashboard.receiveable_earnings') }}
                <span class="pull-right text-primary">{{ $currentOutstandingCustomerPayment }}</span>
            </li>
        </ul>

        <legend style="border-bottom: none" class="text-center">{{ trans('dashboard.upcoming_subscriptions_expiry') }}</legend>

        <div class="panel panel-default table-responsive">
            <table class="table table-condensed">
                <tr>
                    <th class="col-xs-3">@lang('subscription.subscription')</th>
                    <th class="col-xs-3">@lang('customer.customer')</th>
                    <th class="col-xs-3 text-right">@lang('invoice.amount')</th>
                    <th class="col-xs-5 text-center">@lang('subscription.due_date')</th>
                </tr>
                @forelse(AdminDashboard::upcomingSubscriptionDueDatesList() as $subscription)
                <tr>
                    <td>{{ $subscription->nameLink() }}</td>
                    <td>{{ $subscription->customer->name }}</td>
                    <td class="text-right">{{ formatRp($subscription->price) }}</td>
                    <td class="text-center">
                        {{ $subscription->due_date }}
                        {!! $subscription->nearOfDueDateSign() !!}
                    </td>
                </tr>
                @empty
                <tr><td colspan="4">{{ trans('dashboard.no_upcoming_subscriptions_expiry') }}</td></tr>
                @endforelse
            </table>
        </div>
    </div>
</div>
@endsection
