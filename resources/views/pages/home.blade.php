@inject('projectStatuses', 'App\Entities\Projects\Status')

@extends('layouts.dashboard')

@section('title', trans('nav_menu.dashboard'))

@section('content-dashboard')

<?php use Facades\App\Queries\AdminDashboardQuery;?>

<div class="row">
    <div class="col-lg-5">
        <legend style="border-bottom: none" class="text-center">Project Status Stats</legend>
        <div class="row">
            @foreach($projectStatuses::all() as $statusId => $status)
            <div class="col-lg-6 col-md-4 col-xs-6">
                @include('view-components.dashboard-panel', [
                    'class' => $projectStatuses->getColorById($statusId),
                    'icon' => $projectStatuses->getIconById($statusId),
                    'number' => array_key_exists($statusId, $projectStatusStats) ? $projectStatusStats[$statusId] : 0,
                    'text' => $projectStatuses::getNameById($statusId),
                    'linkRoute' => route('projects.index', ['status' => $statusId]),
                ])
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-7">
        <legend style="border-bottom: none" class="text-center">Earnings Stats</legend>
        <div class="panel panel-default table-responsive hidden-xs">
            <table class="table table-condensed table-bordered">
                <tr>
                    <td class="col-xs-2 text-center">Yearly Earnings ({{ $queriedYear }})</td>
                    <td class="col-xs-2 text-center">Finished Projects ({{ $queriedYear }})</td>
                    <td class="col-xs-2 text-center">Current Receiveable Earnings</td>
                </tr>
                <tr>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $totalEarnings = formatRp(AdminDashboardQuery::totalEarnings($queriedYear)) }}
                    </td>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $totalFinishedProjects = AdminDashboardQuery::totalFinishedProjects($queriedYear) }} Projects
                    </td>
                    <td class="text-center text-primary lead" style="border-top: none;">
                        {{ $currentOutstandingCustomerPayment = formatRp(AdminDashboardQuery::currentOutstandingCustomerPayment($queriedYear)) }}
                    </td>
                </tr>
            </table>
        </div>

        <ul class="list-group visible-xs">
            <li class="list-group-item">
                Yearly Earnings ({{ $queriedYear }})
                <span class="pull-right text-primary">{{ $totalEarnings }}</span>
            </li>
            <li class="list-group-item">
                Finished Projects ({{ $queriedYear }})
                <span class="pull-right text-primary">{{ $totalFinishedProjects }} Projects</span>
            </li>
            <li class="list-group-item">
                Current Receiveable Earnings
                <span class="pull-right text-primary">{{ $currentOutstandingCustomerPayment }}</span>
            </li>
        </ul>

        <legend style="border-bottom: none" class="text-center">Upcoming Subscriptions Due Dates</legend>

        <div class="panel panel-default table-responsive">
            <table class="table table-condensed">
                <tr>
                    <th class="col-xs-3">@lang('subscription.subscription')</th>
                    <th class="col-xs-3">@lang('customer.customer')</th>
                    <th class="col-xs-3 text-right">@lang('invoice.amount')</th>
                    <th class="col-xs-5 text-center">@lang('subscription.due_date')</th>
                </tr>
                @foreach(AdminDashboardQuery::upcomingSubscriptionDueDatesList() as $subscription)
                <tr>
                    <td>{{ $subscription->nameLink() }}</td>
                    <td>{{ $subscription->customer->name }}</td>
                    <td class="text-right">{{ formatRp($subscription->price) }}</td>
                    <td class="text-center">
                        {{ $subscription->due_date }}
                        {!! $subscription->nearOfDueDateSign() !!}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
