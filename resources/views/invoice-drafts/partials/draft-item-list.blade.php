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
                <th>#</th>
                <th>Deskripsi</th>
                <th class="text-center">Biaya</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1?>
            @foreach($draft->items() as $key => $item)
            <tr>
                <td>{{ $no }}</td>
                    <?php $no++;?>
                    {{ Form::open(['route' => ['invoice-drafts.update-draft-item', $draft->draftKey], 'method' => 'patch']) }}
                    {{ Form::hidden('item_key', $key) }}
                <td class="col-md-8">
                    {!! FormField::textarea(
                        'description',
                        ['id' => 'description-'.$key, 'value' => $item->description, 'label' => false]
                    ) !!}
                </td>
                <td class="col-md-3">
                    {!! FormField::price(
                        'amount',
                        ['id' => 'amount-'.$key, 'value' => $item->amount, 'label' => false]
                    ) !!}
                    {{ Form::submit('Update', ['id' => 'update-item-'.$key, 'class' => 'btn btn-success btn-xs pull-right']) }}
                </td>
                    {{ Form::close() }}
                <td class="col-md-1 text-center show-on-hover-parent">
                    {!! FormField::delete([
                        'route' => ['invoice-drafts.remove-draft-item', $draft->draftKey],
                        'onsubmit' => 'Yakin ingin menghapus Item ini?',
                        'class' => '',
                    ], 'x', ['id' => 'remove-item-'.$key, 'class' => 'btn btn-danger btn-xs show-on-hover','title' => 'Hapus item ini'], ['item_index' => $key]) !!}
                </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="4">Tambah Item Invoice</th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                {{ Form::open(['route' => ['invoice-drafts.add-draft-item', $draft->draftKey]]) }}
                <td>
                    {!! FormField::textarea(
                        'description',
                        ['id' => 'description', 'label' => false, 'placeholder' => 'Deskripsi Item']
                    ) !!}
                </td>
                <td>
                    {!! FormField::price(
                        'amount',
                        ['id' => 'amount', 'label' => false, 'placeholder' => 'Biaya Item']
                    ) !!}
                </td>
                <td class="text-center">{{ Form::submit('add-item', ['class' => 'btn btn-primary']) }}</td>
                {{ Form::close() }}
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">{{ trans('invoice.amount') }} :</th>
                <th class="text-right">{{ formatRp($draft->getTotal()) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>