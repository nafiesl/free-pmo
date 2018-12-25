@extends('layouts.app')

@section('title', 'Log Files')

@section('content')
<h3 class="page-header">Log Files</h3>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <thead>
                    <th>#</th>
                    <th>Nama File</th>
                    <th>Ukuran</th>
                    <th>Tanggal Jam</th>
                    <th>{{ __('app.action') }}</th>
                </thead>
                <tbody>
                    @forelse($logFiles as $key => $logFile)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $logFile->getFilename() }}</td>
                        <td>{{ format_size_units($logFile->getSize()) }}</td>
                        <td>{{ date('Y-m-d H:i:s', $logFile->getMTime()) }}</td>
                        <td>
                            {!! html_link_to_route('log-files.download', '', [$logFile->getFilename()], [
                                'class'=>'btn btn-default btn-xs',
                                'icon' => 'download',
                                'id' => 'download-'.$logFile->getFilename(),
                                'title' => 'Download file '.$logFile->getFilename()
                            ]) !!}
                            {!! html_link_to_route('log-files.show', '', [$logFile->getFilename()], [
                                'class'=>'btn btn-default btn-xs',
                                'icon' => 'search',
                                'id' => 'view-'.$logFile->getFilename(),
                                'title' => 'View file '.$logFile->getFilename(),
                                'target' => '_blank',
                            ]) !!}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">Belum ada file logFile</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
