@if (Request::get('action') == 'delete' && $partner)
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('partner.delete') }}</h3></div>
            <div class="panel-body">
                <label class="control-label">{{ trans('partner.name') }}</label>
                <p>{{ $partner->name }}</p>
                <label class="control-label">{{ trans('contact.email') }}</label>
                <p>{{ $partner->email }}</p>
                <label class="control-label">{{ trans('contact.phone') }}</label>
                <p>{{ $partner->phone }}</p>
                <label class="control-label">{{ trans('address.address') }}</label>
                <p>{{ $partner->address }}</p>
                <label class="control-label">{{ trans('app.status') }}</label>
                <p>{{ $partner->is_active }}</p>
                <label class="control-label">{{ trans('app.notes') }}</label>
                <p>{{ $partner->notes }}</p>
                {!! $errors->first('partner_id', '<span class="form-error small">:message</span>') !!}
            </div>
            <hr style="margin:0">
            <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
            <div class="panel-footer">
                {!! FormField::delete(
                    ['route'=>['partners.destroy',$partner->id]],
                    trans('app.delete_confirm_button'),
                    ['class'=>'btn btn-danger'],
                    [
                        'partner_id' => $partner->id,
                        'page' => request('page'),
                        'q' => request('q'),
                    ]
                ) !!}
                {{ link_to_route('partners.edit', trans('app.cancel'), [$partner->id], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
</div>
@endif
