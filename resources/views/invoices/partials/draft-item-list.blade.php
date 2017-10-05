<legend>
    {{ trans('invoice.items') }}
    <small class="text-muted">
        ({{ $draft->getItemsCount() }} Item)
    </small>
</legend>

<div class="panel panel-default">
    <div class="panel-body table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Deskripsi</th>
                    <th>Biaya</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1 ?>
            @forelse($draft->items() as $key => $item)
                <tr>
                    <td>{{ $no }} <?php $no++ ?></td>
                        {{ Form::open(['route' => ['cart.update-draft-item', $draft->draftKey], 'method' => 'patch']) }}
                        {{ Form::hidden('item_key', $key) }}
                    <td>{{ Form::text('description', $item->description, ['id' => 'description-' . $key]) }}</td>
                    <td>
                        {{ Form::number('amount', $item->amount, ['id' => 'amount-' . $key]) }}
                    </td>
                        {{ Form::submit('update-item-' . $key, ['style'=>'display:none']) }}
                        {{ Form::close() }}
                    <td class="text-center show-on-hover-parent">
                        {!! FormField::delete([
                            'route' => ['cart.remove-draft-item', $draft->draftKey],
                            'onsubmit' => 'Yakin ingin menghapus Item ini?',
                            'class' => '',
                        ], 'x', ['id' => 'remove-item-' . $key, 'class' => 'btn btn-danger btn-xs show-on-hover','title' => 'Hapus item ini'], ['item_index' => $key]) !!}
                    </td>
                </tr>
            @empty
            @endforelse
                <tr>
                    <td></td>
                    {{ Form::open(['route' => ['cart.add-draft-item', $draft->draftKey]]) }}
                    <td>{{ Form::text('description', null, ['id' => 'description']) }}</td>
                    <td>
                        {{ Form::number('amount', null, ['id' => 'amount']) }}
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
</div>