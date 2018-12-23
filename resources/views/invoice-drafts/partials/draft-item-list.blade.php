<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ trans('invoice.items') }}
            <small class="text-muted">({{ $draft->getItemsCount() }} Item)</small>
        </h3>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('app.table_no') }}</th>
                <th>{{ __('app.description') }}</th>
                <th class="text-center">{{ __('invoice.item_amount') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1?>
            @foreach($draft->items() as $key => $item)
            <tr>
                <td>{{ $no }}</td>
                    <?php $no++;?>
                    {{ Form::open(['route' => ['invoice-drafts.update-draft-item', $draft->draftKey], 'method' => 'patch']) }}
                    {{ Form::hidden('item_key['.$key.']', $key) }}
                <td class="col-md-8">
                    {!! FormField::textarea(
                        'description['.$key.']',
                        ['id' => 'description-'.$key, 'value' => $item->description, 'label' => false]
                    ) !!}
                </td>
                <td class="col-md-3">
                    {!! FormField::price(
                        'amount['.$key.']',
                        [
                            'id' => 'amount-'.$key,
                            'value' => $item->amount,
                            'label' => false,
                            'currency' => Option::get('money_sign', 'Rp')
                        ]
                    ) !!}
                    {{ Form::submit(__('app.update'), ['id' => 'update-item-'.$key, 'class' => 'btn btn-success btn-xs pull-right']) }}
                </td>
                    {{ Form::close() }}
                <td class="col-md-1 text-center show-on-hover-parent">
                    {!! FormField::delete([
                        'route' => ['invoice-drafts.remove-draft-item', $draft->draftKey],
                        'class' => '',
                    ], 'x', ['id' => 'remove-item-'.$key, 'class' => 'btn btn-danger btn-xs show-on-hover', 'title' => __('invoice.item_remove')], ['item_index' => $key]) !!}
                </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="2" class="text-right">{{ trans('invoice.amount') }} :</th>
                <th class="text-right">{{ format_money($draft->getTotal()) }}</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th colspan="4">{{ __('app.add') }} {{ __('invoice.items') }}</th>
            </tr>
            <tr>
                {{ Form::open(['route' => ['invoice-drafts.add-draft-item', $draft->draftKey]]) }}
                <td colspan="2">
                    {!! FormField::textarea(
                        'new_item_description',
                        ['id' => 'new_item_description', 'label' => false, 'placeholder' => trans('invoice.item_description')]
                    ) !!}
                </td>
                <td colspan="2">
                    {!! FormField::price(
                        'new_item_amount',
                        [
                            'id' => 'new_item_amount',
                            'label' => false,
                            'placeholder' => trans('invoice.item_amount'),
                            'currency' => Option::get('money_sign', 'Rp')
                        ]
                    ) !!}
                    {{ Form::submit(trans('invoice.add_item'), ['class' => 'btn btn-primary btn-block']) }}
                </td>
                {{ Form::close() }}
            </tr>
        </tbody>
    </table>
</div>