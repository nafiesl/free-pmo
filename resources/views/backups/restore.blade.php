@extends('layouts.app')

@section('content')
<br>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">
            Apakah anda yakin akan mengembalikan seluruh data sesuai file ini <strong>"{{ $fileName }}"</strong>? <br>
            Pastikan data saat ini sudah dibackup.
        </h3>
    </div>
    <div class="panel-footer">
        {!! link_to_route('backups.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
        <div class="pull-right">
            {!! Form::open(['route'=>['backups.restore', $fileName]]) !!}
            {!! Form::hidden('file_name', $fileName) !!}
            {!! Form::submit('Restore Database', ['class'=>'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection