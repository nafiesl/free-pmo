@inject('projectStatuses', 'App\Entities\Projects\Status')

@extends('layouts.dashboard')

@section('title', trans('nav_menu.dashboard'))

@section('content-dashboard')

<div class="row">
    <div class="col-md-6">
        <legend style="border-bottom: none" class="text-center">Project Status Stats</legend>
        <div class="row">
            @foreach($projectStatuses::all() as $statusId => $status)
            @if ($statusId == 4)
            <div class="row">
            @endif
            <div class="col-md-4">
                @include('view-components.dashboard-panel', [
                    'class' => $projectStatuses->getColorById($statusId),
                    'icon' => $projectStatuses->getIconById($statusId),
                    'number' => array_key_exists($statusId, $projectStatusStats) ? $projectStatusStats[$statusId] : 0,
                    'text' => $projectStatuses::getNameById($statusId),
                    'linkRoute' => route('projects.index', ['status' => $statusId]),
                ])
            </div>
            @if ($statusId == 3)
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="col-md-6">
        <legend style="border-bottom: none" class="text-center">Earnings Stats</legend>
        <div class="panel panel-default table-responsive hidden-xs">
            <table class="table table-condensed table-bordered">
                <tr>
                    <td class="col-xs-2 text-center">Yearly Earnings (2017)</td>
                    <td class="col-xs-2 text-center">Finished Project (2017)</td>
                    <td class="col-xs-2 text-center">Receiveable Earnings</td>
                </tr>
                <tr>
                    <td class="text-center lead" style="border-top: none;">{{ formatRp(1000000) }}</td>
                    <td class="text-center lead" style="border-top: none;">0 Projects</td>
                    <td class="text-center lead" style="border-top: none;">{{ formatRp(1000000) }}</td>
                </tr>
            </table>
        </div>

        <ul class="list-group visible-xs">
            <li class="list-group-item">Earnings (2017) <span class="pull-right">{{ formatRp(1000000) }}</span></li>
            <li class="list-group-item">Finished Project (2017) <span class="pull-right">0 Projects</span></li>
            <li class="list-group-item">Receiveable Earnings <span class="pull-right">{{ formatRp(1000000) }}</span></li>
        </ul>

        <legend style="border-bottom: none" class="text-center">Upcoming Subscriptions Due Dates</legend>

        <div class="panel panel-default">
            <table class="table table-condensed">
                <tr>
                    <th class="col-xs-2">Project</th>
                    <th class="col-xs-3">Items</th>
                    <th class="col-xs-2 text-right">Tagihan</th>
                    <th class="col-xs-2 text-center">Due Date</th>
                </tr>
                @foreach(range(1, 4) as $subscription)
                <tr>
                    <td>Project {{ $subscription }}</td>
                    <td>Hosting &amp; Domain</td>
                    <td class="text-right">{{ formatRp(rand(1, 3).'000000') }}</td>
                    <td class="text-center">2017-12-01</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
