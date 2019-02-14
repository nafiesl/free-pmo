@extends('layouts.app')

@section('title', __('backup.index_title'))

@section('content')
<ul class="breadcrumb hidden-print">
    <li><a href="{{ route('backups.index') }}">{{ __('backup.index_title') }}</a></li>
    <li class="active">{{ __('backup.list') }}</li>
</ul>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <thead>
                    <th>{{ __('app.table_no') }}</th>
                    <th>{{ __('backup.file_name') }}</th>
                    <th>{{ __('backup.file_size') }}</th>
                    <th>{{ __('backup.created_at') }}</th>
                    <th class="text-center">{{ __('backup.actions') }}</th>
                </thead>
                <tbody>
                    @forelse($backups as $key => $backup)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $backup->getFilename() }}</td>
                        <td>{{ format_size_units($backup->getSize()) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $backup->getMTime()) }}</td>
                        <td class="text-center">
                            <a href="{{ route('backups.index', ['action' => 'restore', 'file_name' => $backup->getFilename()]) }}"
                                id="restore_{{ str_replace('.gz', '', $backup->getFilename()) }}"
                                class="btn btn-warning btn-xs"
                                title="{{ __('backup.restore') }}"><i class="fa fa-rotate-left"></i></a>
                            <a href="{{ route('backups.download', [$backup->getFilename()]) }}"
                                id="download_{{ str_replace('.gz', '', $backup->getFilename()) }}"
                                class="btn btn-info btn-xs"
                                title="{{ __('backup.download') }}"><i class="fa fa-download"></i></a>
                            <a href="{{ route('backups.index', ['action' => 'delete', 'file_name' => $backup->getFilename()]) }}"
                                id="del_{{ str_replace('.gz', '', $backup->getFilename()) }}"
                                class="btn btn-danger btn-xs"
                                title="{{ __('backup.delete') }}"><i class="fa fa-remove"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">{{ __('backup.empty') }}</td></tr>
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
