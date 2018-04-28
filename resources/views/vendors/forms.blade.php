@if (Request::get('action') == 'create')
    {!! Form::open(['route' => 'vendors.store']) !!}
    {!! FormField::text('name', ['required' => true]) !!}
    {!! FormField::text('website') !!}
    {!! FormField::textarea('notes') !!}
    {!! Form::submit(trans('vendor.create'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('vendors.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endif
@if (Request::get('action') == 'edit' && $editableVendor)
    {!! Form::model($editableVendor, ['route' => ['vendors.update', $editableVendor->id],'method' => 'patch']) !!}
    {!! FormField::text('name', ['required' => true]) !!}
    {!! FormField::text('website') !!}
    {!! FormField::radios('is_active', ['Non Aktif', 'Aktif']) !!}
    {!! FormField::textarea('notes') !!}
    @if (request('q'))
        {{ Form::hidden('q', request('q')) }}
    @endif
    @if (request('page'))
        {{ Form::hidden('page', request('page')) }}
    @endif
    {!! Form::submit(trans('vendor.update'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('vendors.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endif
@if (Request::get('action') == 'delete' && $editableVendor)
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('vendor.delete') }}</h3></div>
        <div class="panel-body">
            <label class="control-label">{{ trans('vendor.name') }}</label>
            <p>{{ $editableVendor->name }}</p>
            {!! $errors->first('vendor_id', '<span class="form-error small">:message</span>') !!}
        </div>
        <hr style="margin:0">
        @can('delete', $editableVendor)
            <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
        @else
            <div class="panel-body">{{ trans('vendor.undeleteable') }}</div>
        @endcan
        <div class="panel-footer">
            @can('delete', $editableVendor)
            {!! FormField::delete(
                ['route'=>['vendors.destroy',$editableVendor->id]],
                trans('app.delete_confirm_button'),
                ['class'=>'btn btn-danger'],
                [
                    'vendor_id' => $editableVendor->id,
                    'page' => request('page'),
                    'q' => request('q'),
                ]
            ) !!}
            @endcan
            {{ link_to_route('vendors.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        </div>
    </div>
@endif
