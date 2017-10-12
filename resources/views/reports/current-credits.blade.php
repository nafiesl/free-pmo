@extends('layouts.app')

@section('title', 'Piutang Saat Ini')

@section('content')
<ul class="breadcrumb hidden-print">
    <li class="active">Piutang Saat Ini</li>
</ul>

<table class="table table-condensed table-hover">
    <thead>
        <th>{{ trans('app.table_no') }}</th>
        <th class="col-md-2">{{ trans('project.project') }}</th>
        <th class="col-md-2 text-right">{{ trans('project.project_value') }}</th>
        <th class="col-md-2 text-right">{{ trans('project.cash_in_total') }}</th>
        <th class="col-md-2 text-right">Sisa</th>
        <th class="col-md-2">{{ trans('project.customer') }}</th>
        <th class="col-md-2 text-center">{{ trans('project.status') }}</th>
    </thead>
    <tbody>
        <?php $total = 0 ?>
        @forelse($projects as $key => $project)
        <tr>
            <td>{{ 1 + $key }}</td>
            <td>{!! link_to_route('projects.payments',$project->name,[$project->id],['title' => 'Lihat Daftar Pembayaran','target' => '_blank']) !!}</td>
            <td class="text-right">{{ formatRp($project->project_value) }}</td>
            <td class="text-right">{{ formatRp($project->cashInTotal()) }}</td>
            <td class="text-right">{{ formatRp($project->balance = $project->project_value - $project->cashInTotal()) }}</td>
            <td>{{ $project->customer->name }}</td>
            <td class="text-center">{{ $project->present()->status }}</td>
        </tr>
        @empty
        <tr><td colspan="8">{{ trans('project.not_found') }}</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="4">Jumlah</th>
            <th class="text-right">{{ formatRp($projects->sum('balance')) }}</th>
            <th colspan="3"></th>
        </tr>
    </tfoot>
</table>
@endsection