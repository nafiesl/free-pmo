@extends('layouts.app')

@section('content')
<br>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">
            Apakah anda yakin akan menghapus file backup <strong>"{{ $fileName }}"</strong> ini?
        </h3>
    </div>
    <div class="panel-footer">
        {!! link_to_route('backups.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
        <div class="pull-right">
            {!! Form::open(['route'=>['backups.destroy', $fileName], 'method' => 'delete']) !!}
            {!! Form::hidden('file_name', $fileName) !!}
            {!! Form::submit('Hapus File', ['class'=>'btn btn-danger']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection