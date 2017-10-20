@extends('layouts.app')

@section('title',trans('backup.index_title'))

@section('content')
<ul class="breadcrumb hidden-print">
    <li><a href="{{ route('backups.index') }}">@lang('backup.index_title')</a></li>
    <li class="active">@lang('backup.list')</li>
</ul>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <thead>
                    <th>@lang('app.table_no')</th>
                    <th>@lang('backup.file_name')</th>
                    <th>@lang('backup.file_size')</th>
                    <th>@lang('backup.created_at')</th>
                    <th class="text-center">@lang('backup.actions')</th>
                </thead>
                <tbody>
                    @forelse($backups as $key => $backup)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $backup->getFilename() }}</td>
                        <td>{{ formatSizeUnits($backup->getSize()) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $backup->getMTime()) }}</td>
                        <td class="text-center">
                            <a href="{{ route('backups.index', ['action' => 'restore', 'file_name' => $backup->getFilename()]) }}"
                                id="restore_{{ str_replace('.gz', '', $backup->getFilename()) }}"
                                class="btn btn-warning btn-xs"
                                title="@lang('backup.download')">@lang('backup.restore')</a>
                            <a href="{{ route('backups.download', [$backup->getFilename()]) }}"
                                id="download_{{ str_replace('.gz', '', $backup->getFilename()) }}"
                                class="btn btn-info btn-xs"
                                title="@lang('backup.download')">@lang('backup.download')</a>
                            <a href="{{ route('backups.index', ['action' => 'delete', 'file_name' => $backup->getFilename()]) }}"
                                id="del_{{ str_replace('.gz', '', $backup->getFilename()) }}"
                                class="btn btn-danger btn-xs"
                                title="@lang('backup.delete')">@lang('backup.delete')</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">@lang('backup.empty')</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        @include('backups.forms')
    </div>
</div>
@endsection
