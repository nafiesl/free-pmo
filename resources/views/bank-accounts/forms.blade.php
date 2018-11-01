@if (Request::get('action') == 'create')
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('bank_account.create') }}</h3></div>
    {!! Form::open(['route' => 'bank-accounts.store']) !!}
    <div class="panel-body">
        {!! FormField::text('name', ['required' => true, 'label' => trans('bank_account.name')]) !!}
        {!! FormField::text('number', ['required' => true, 'label' => trans('bank_account.number')]) !!}
        {!! FormField::text('account_name', ['required' => true, 'label' => trans('bank_account.account_name')]) !!}
        {!! FormField::textarea('description', ['label' => trans('bank_account.description')]) !!}
    </div>
    <div class="panel-footer">
        {!! Form::submit(trans('bank_account.create'), ['class' => 'btn btn-success']) !!}
        {{ link_to_route('bank-accounts.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    </div>
    {!! Form::close() !!}
</div>
@endif
@if (Request::get('action') == 'edit' && $editableBankAccount)
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('bank_account.edit') }}</h3></div>
    {!! Form::model($editableBankAccount, ['route' => ['bank-accounts.update', request('id')],'method' => 'patch']) !!}
    <div class="panel-body">
        {!! FormField::text('name', ['required' => true, 'label' => trans('bank_account.name')]) !!}
        {!! FormField::text('number', ['required' => true, 'label' => trans('bank_account.number')]) !!}
        {!! FormField::text('account_name', ['required' => true, 'label' => trans('bank_account.account_name')]) !!}
        {!! FormField::textarea('description', ['label' => trans('bank_account.description')]) !!}
        {!! FormField::radios('is_active', [__('app.in_active'), __('app.active')], ['label' => __('app.status')]) !!}
    </div>
    <div class="panel-footer">
        {!! Form::submit(trans('bank_account.update'), ['class' => 'btn btn-success']) !!}
        {{ link_to_route('bank-accounts.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    </div>
    {!! Form::close() !!}
</div>
@endif
@if (Request::get('action') == 'delete' && $editableBankAccount)
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('bank_account.delete') }}</h3></div>
        <div class="panel-body">
            <label class="control-label">{{ trans('bank_account.name') }}</label>
            <p>{{ $editableBankAccount->name }}</p>
            <label class="control-label">{{ trans('bank_account.number') }}</label>
            <p>{{ $editableBankAccount->number }}</p>
            <label class="control-label">{{ trans('bank_account.account_name') }}</label>
            <p>{{ $editableBankAccount->account_name }}</p>
            <label class="control-label">{{ trans('bank_account.description') }}</label>
            <p>{{ $editableBankAccount->description }}</p>
            {!! $errors->first('bank_account_id', '<span class="form-error small">:message</span>') !!}
        </div>
        <hr style="margin:0">
        <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
        <div class="panel-footer">
            {!! FormField::delete(
                ['route'=>['bank-accounts.destroy',request('id')]],
                trans('app.delete_confirm_button'),
                ['class'=>'btn btn-danger'],
                [
                    'bank_account_id' => request('id'),
                    'page' => request('page'),
                    'q' => request('q'),
                ]
            ) !!}
            {{ link_to_route('bank-accounts.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        </div>
    </div>
@endif
