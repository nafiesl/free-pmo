@extends('layouts.app')

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! delete_button(['route'=>['options.destroy',$option->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger'], ['option_id'=>$option->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('options.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">Option Detail</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr><th>{{ str_split_ucwords($option->key) }}</th><td>{{ $option->value }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection