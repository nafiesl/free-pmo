<table class="table table-condensed table-bordered">
    <tbody>
        <tr>
            <th class="text-center">&nbsp;</th>
            <th class="text-center">{{ __('job.starts') }}</th>
            <th class="text-center">{{ __('job.ends') }}</th>
            <th class="text-center">{{ __('job.duration') }}</th>
        </tr>
        <tr>
            <th class="text-center">{{ __('job.target') }}</th>
            <td class="text-center">{{ $job->target_start_date }}</td>
            <td class="text-center">{{ $job->target_end_date }}</td>
            <td class="text-center">{{ Carbon::parse($job->target_start_date)->diffInDays(Carbon::parse($job->target_end_date), false) }} {{ __('time.days') }}</td>
        </tr>
        <tr>
            <th class="text-center">{{ __('job.actual') }}</th>
            <td class="text-center">{{ $job->actual_start_date }}</td>
            <td class="text-center">{{ $job->actual_end_date }}</td>
            <td class="text-center">{{ Carbon::parse($job->actual_start_date)->diffInDays(Carbon::parse($job->actual_end_date), false) }} {{ __('time.days') }}</td>
        </tr>
    </tbody>
</table>
