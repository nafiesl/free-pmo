@extends('layouts.app')

@section('title','Daftar Backup Database Sistem')

@section('content')
<h1 class="page-header">
    Daftar Backup Database Sistem
</h1>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Daftar File Backup</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <thead>
                        <th>#</th>
                        <th>Nama File</th>
                        <th>Ukuran</th>
                        <th>Tanggal Jam</th>
                        <th>{{ trans('app.action') }}</th>
                    </thead>
                    <tbody>
                        @forelse($backups as $key => $backup)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $backup->getFilename() }}</td>
                            <td>{{ formatSizeUnits($backup->getSize()) }}</td>
                            <td>{{ date('Y-m-d H:i:s', $backup->getMTime()) }}</td>
                            <td>
                                {!! link_to_route('backups.download','Download',[$backup->getFilename()],['class'=>'btn btn-default btn-xs','target' => '_blank']) !!}
                                {!! link_to_route('backups.restore','Restore',[$backup->getFilename()],['class'=>'btn btn-warning btn-xs']) !!}
                                {!! link_to_route('backups.delete','x',[$backup->getFilename()],['class'=>'btn btn-danger btn-xs']) !!}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">Belum ada file backup</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                {!! Form::open(['route' => 'backups.store','class' => '']) !!}
                {!! FormField::text('file_name', ['label' => 'Buat Backup Database', 'placeholder' => date('Y-m-d_Hi')]) !!}
                {!! Form::submit('Buat Backup', ['class' => 'btn btn-success']) !!}
                {!! Form::close() !!}

                <hr>

                {!! Form::open(['route' => 'backups.upload','class' => '', 'files' => true]) !!}
                {!! FormField::file('backup_file', ['label' => 'Upload File Backup','placeholder'=>'Pilih File']) !!}
                {!! Form::submit('Upload', ['class' => 'btn btn-info']) !!}
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>
@endsection
