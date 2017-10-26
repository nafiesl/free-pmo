@if (Request::get('action') == 'create')
    {!! Form::open(['route' => 'customers.store']) !!}
    {!! FormField::text('name', ['required' => true]) !!}
    {!! FormField::email('email') !!}
    {!! FormField::text('phone') !!}
    {!! FormField::text('pic') !!}
    {!! FormField::textarea('address') !!}
    {!! FormField::textarea('notes') !!}
    {!! Form::submit(trans('customer.create'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('customers.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endif
@if (Request::get('action') == 'edit' && $editableCustomer)
    {!! Form::model($editableCustomer, ['route' => ['customers.update', $editableCustomer->id],'method' => 'patch']) !!}
    {!! FormField::text('name', ['required' => true]) !!}
    {!! FormField::email('email') !!}
    {!! FormField::text('phone') !!}
    {!! FormField::text('pic') !!}
    {!! FormField::textarea('address') !!}
    {!! FormField::textarea('notes') !!}
    {!! FormField::radios('is_active', ['Non Aktif', 'Aktif']) !!}
    @if (request('q'))
        {{ Form::hidden('q', request('q')) }}
    @endif
    @if (request('page'))
        {{ Form::hidden('page', request('page')) }}
    @endif
    {!! Form::submit(trans('customer.update'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('customers.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endif
@if (Request::get('action') == 'delete' && $editableCustomer)
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('customer.delete') }}</h3></div>
        <div class="panel-body">
            <label class="control-label">{{ trans('customer.name') }}</label>
            <p>{{ $editableCustomer->name }}</p>
            <label class="control-label">{{ trans('contact.email') }}</label>
            <p>{{ $editableCustomer->email }}</p>
            <label class="control-label">{{ trans('contact.phone') }}</label>
            <p>{{ $editableCustomer->phone }}</p>
            <label class="control-label">{{ trans('app.address') }}</label>
            <p>{{ $editableCustomer->address }}</p>
            <label class="control-label">{{ trans('app.status') }}</label>
            <p>{{ $editableCustomer->is_active }}</p>
            <label class="control-label">{{ trans('app.notes') }}</label>
            <p>{{ $editableCustomer->notes }}</p>
            {!! $errors->first('customer_id', '<span class="form-error small">:message</span>') !!}
        </div>
        <hr style="margin:0">
        <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
        <div class="panel-footer">
            {!! FormField::delete(
                ['route'=>['customers.destroy',$editableCustomer->id]],
                trans('app.delete_confirm_button'),
                ['class'=>'btn btn-danger'],
                [
                    'customer_id' => $editableCustomer->id,
                    'page' => request('page'),
                    'q' => request('q'),
                ]
            ) !!}
            {{ link_to_route('customers.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        </div>
    </div>
@endif
