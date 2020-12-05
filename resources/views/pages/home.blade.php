@extends('layouts.dashboard')

@section('title', __('nav_menu.dashboard'))

@section('content-dashboard')
@if (auth()->user()->hasRole('admin'))
<div class="row">
    <div class="col-lg-5">
        <legend style="border-bottom: none" class="text-center">{{ __('dashboard.project_status_stats') }}</legend>
        <div class="row">
            @foreach(ProjectStatus::all() as $statusId => $status)
            <div class="col-lg-6 col-md-4 col-xs-6">
                @include('view-components.dashboard-panel', [
                    'class' => ProjectStatus::getColorById($statusId),
                    'icon' => ProjectStatus::getIconById($statusId),
                    'number' => array_key_exists($statusId, $projectStatusStats) ? $projectStatusStats[$statusId] : 0,
                    'text' => ProjectStatus::getNameById($statusId),
                    'linkRoute' => route('projects.index', ['status_id' => $statusId]),
                ])
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-7">
        <legend style="border-bottom: none" class="text-center">{{ __('dashboard.earnings_stats') }}</legend>
        <div class="panel panel-default table-responsive hidden-xs">
            <table class="table table-condensed table-bordered">
                <tr>
                    <td class="col-xs-2 text-center">{{ __('dashboard.yearly_earnings') }} ({{ $queriedYear }})</td>
                    <td class="col-xs-2 text-center">{{ __('dashboard.finished_projects_count') }} ({{ $queriedYear }})</td>
                    <td class="col-xs-2 text-center">{{ __('dashboard.receiveable_earnings') }}</td>
                </tr>
                <tr>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $totalEarnings = format_money(AdminDashboard::totalEarnings($queriedYear)) }}
                    </td>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $totalFinishedProjects = AdminDashboard::totalFinishedProjects($queriedYear) }} Projects
                    </td>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $currentOutstandingCustomerPayment = format_money(AdminDashboard::currentOutstandingCustomerPayment($queriedYear)) }}
                    </td>
                </tr>
            </table>
        </div>

        <ul class="list-group visible-xs">
            <li class="list-group-item">
                {{ __('dashboard.yearly_earnings') }} ({{ $queriedYear }})
                <span class="pull-right text-primary">{{ $totalEarnings }}</span>
            </li>
            <li class="list-group-item">
                {{ __('dashboard.finished_projects_count') }} ({{ $queriedYear }})
                <span class="pull-right text-primary">{{ $totalFinishedProjects }} Projects</span>
            </li>
            <li class="list-group-item">
                {{ __('dashboard.receiveable_earnings') }}
                <span class="pull-right text-primary">{{ $currentOutstandingCustomerPayment }}</span>
            </li>
        </ul>

        <legend style="border-bottom: none" class="text-center">{{ __('dashboard.upcoming_subscriptions_expiry') }}</legend>

        <div class="panel panel-default table-responsive">
            <table class="table table-condensed">
                <tr>
                    <th class="col-xs-3">{{ __('subscription.subscription') }}</th>
                    <th class="col-xs-3">{{ __('customer.customer') }}</th>
                    <th class="col-xs-3 text-right">{{ __('invoice.amount') }}</th>
                    <th class="col-xs-5 text-center">{{ __('subscription.due_date') }}</th>
                </tr>
                @forelse(AdminDashboard::upcomingSubscriptionDueDatesList() as $subscription)
                <tr>
                    <td>{{ $subscription->name_link }}</td>
                    <td>{{ $subscription->customer->name }}</td>
                    <td class="text-right">{{ format_money($subscription->price) }}</td>
                    <td class="text-center">
                        {{ $subscription->due_date }}
                        {!! $subscription->nearOfDueDateSign() !!}
                    </td>
                </tr>
                @empty
                <tr><td colspan="4">{{ __('dashboard.no_upcoming_subscriptions_expiry') }}</td></tr>
                @endforelse
                <tr><th colspan="4" class="text-center">{{ link_to_route('subscriptions.index', __('subscription.view_all')) }}</th></tr>
            </table>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-4 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('user.current_jobs') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    @php
                        $currentJobTotal = 0;
                    @endphp
                    <tr>
                        <th class="text-center">{{ __('job.progress') }}</th>
                        <th class="text-center">{{ __('user.jobs_count') }}</th>
                    </tr>
                    <tr>
                        <td class="text-center">0 - 10%</td>
                        <td class="text-center">
                            {{ $count = $userCurrentJobs->filter(function ($job) {
                                return $job->progress == 0;
                            })->count() }}
                            @php
                                $currentJobTotal += $count;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">11 - 50%</td>
                        <td class="text-center">
                            {{ $count = $userCurrentJobs->filter(function ($job) {
                                return $job->progress > 10 && $job->progress <= 50;
                            })->count() }}
                            @php
                                $currentJobTotal += $count;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">51 - 75%</td>
                        <td class="text-center">
                            {{ $count = $userCurrentJobs->filter(function ($job) {
                                return $job->progress > 50 && $job->progress <= 75;
                            })->count() }}
                            @php
                                $currentJobTotal += $count;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">76 - 99%</td>
                        <td class="text-center">
                            {{ $count = $userCurrentJobs->filter(function ($job) {
                                return $job->progress > 75 && $job->progress <= 99;
                            })->count() }}
                            @php
                                $currentJobTotal += $count;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">100%</td>
                        <td class="text-center">
                            {{ $count = $userCurrentJobs->filter(function ($job) {
                                return $job->progress == 100;
                            })->count() }}
                            @php
                                $currentJobTotal += $count;
                            @endphp
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="border-top: 4px solid #ccc">
                        <th class="text-center">{{ __('app.total') }}</th>
                        <th class="text-center">{{ $currentJobTotal }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endif
@endsection
