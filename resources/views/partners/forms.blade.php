@if (Request::get('action') == 'create')
    {!! Form::open(['route' => 'partners.store']) !!}
    {!! FormField::text('name', ['required' => true]) !!}
    {!! FormField::email('email') !!}
    {!! FormField::text('phone') !!}
    {!! FormField::text('pic') !!}
    {!! FormField::textarea('address') !!}
    {!! FormField::textarea('notes') !!}
    {!! Form::submit(trans('partner.create'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('partners.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endif
@if (Request::get('action') == 'edit' && $editablePartner)
    {!! Form::model($editablePartner, ['route' => ['partners.update', $editablePartner->id],'method' => 'patch']) !!}
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
    {!! Form::submit(trans('partner.update'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('partners.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endif
@if (Request::get('action') == 'delete' && $editablePartner)
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('partner.delete') }}</h3></div>
        <div class="panel-body">
            <label class="control-label">{{ trans('partner.name') }}</label>
            <p>{{ $editablePartner->name }}</p>
            <label class="control-label">{{ trans('contact.email') }}</label>
            <p>{{ $editablePartner->email }}</p>
            <label class="control-label">{{ trans('contact.phone') }}</label>
            <p>{{ $editablePartner->phone }}</p>
            <label class="control-label">{{ trans('app.address') }}</label>
            <p>{{ $editablePartner->address }}</p>
            <label class="control-label">{{ trans('app.status') }}</label>
            <p>{{ $editablePartner->is_active }}</p>
            <label class="control-label">{{ trans('app.notes') }}</label>
            <p>{{ $editablePartner->notes }}</p>
            {!! $errors->first('partner_id', '<span class="form-error small">:message</span>') !!}
        </div>
        <hr style="margin:0">
        <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
        <div class="panel-footer">
            {!! FormField::delete(
                ['route'=>['partners.destroy',$editablePartner->id]],
                trans('app.delete_confirm_button'),
                ['class'=>'btn btn-danger'],
                [
                    'partner_id' => $editablePartner->id,
                    'page' => request('page'),
                    'q' => request('q'),
                ]
            ) !!}
            {{ link_to_route('partners.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        </div>
    </div>
@endif
