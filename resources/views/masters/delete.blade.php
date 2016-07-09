@extends('layouts.app')

@section('title', trans('master.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! delete_button(['route'=>['masters.destroy',$master->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['master_id'=>$master->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('masters.show', trans('app.cancel'), [$master->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('master.show') }}</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ trans('master.name') }}</th><td>{{ $master->name }}</td></tr>
                        <tr><th>{{ trans('app.description') }}</th><td>{{ $master->description }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection