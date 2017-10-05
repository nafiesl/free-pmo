<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.confirm') }}</h3></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Deskripsi</th>
                            <th class="text-right">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($draft->items() as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->description }}</td>
                            <td class="text-right">{{ formatRp($item->amount) }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">{{ trans('invoice.total') }} :</th>
                            <th class="text-right">{{ formatRp($draft->getTotal()) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.detail') }}</h3></div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td>{{ trans('invoice.project') }}</td>
                            <td>
                                {{ App\Entities\Projects\Project::findOrFail($draft->projectId)->name }}
                            </td>
                        </tr>
                        <tr><td>{{ trans('invoice.total') }}</td><th class="text-right">{{ formatRp($draft->getTotal()) }}</th></tr>
                        <tr><td>{{ trans('invoice.notes') }}</td><td>{{ $draft->notes }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                {{ Form::open(['route' => ['invoices.store', $draft->draftKey]]) }}
                {{ Form::submit(trans('invoice.save'), ['id' => 'save-invoice-draft', 'class' => 'btn btn-success']) }}
                {{ link_to_route('invoices.create', trans('app.back'), $draft->draftKey, ['class' => 'btn btn-default']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>