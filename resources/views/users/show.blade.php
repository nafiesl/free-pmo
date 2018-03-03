@extends('layouts.user')

@section('action-buttons')
{!! link_to_route('users.edit', trans('user.edit'), [$user], ['id' => 'edit-user-' . $user->id, 'class' => 'btn btn-warning']) !!}
{!! link_to_route('users.index', trans('user.back_to_index'), [], ['class' => 'btn btn-default']) !!}
@endsection

@section('content-user')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {{ $user->name }} | {{ trans('user.profile') }}
                </h3>
            </div>
            <table class="table">
                <tr><th class="col-xs-3">{{ trans('user.user_id') }}</th><td>{{ $user->id }}</td></tr>
                <tr><th>{{ trans('user.name') }}</th><td>{{ $user->name }}</td></tr>
                <tr><th>{{ trans('user.email') }}</th><td>{{ $user->email }}</td></tr>
                <tr><th>{{ trans('user.role') }}</th><td>{!! $user->roleList() !!}</td></tr>
                <tr><th>{{ trans('lang.lang') }}</th><td>{{ trans('lang.'.$user->lang) }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{$user->name}} | {{ trans('user.current_jobs') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    @php
                        $currentJobTotal = 0;
                    @endphp
                    <tr>
                        <th class="text-center">{{ trans('job.progress') }}</th>
                        <th class="text-center">{{ trans('user.jobs_count') }}</th>
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
                        <th class="text-center">{{ trans('app.total') }}</th>
                        <th class="text-center">{{ $currentJobTotal }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
