<div class="alert alert-warning">
    {!! trans('invoice.confirm_instruction', [
        'back_link' => link_to_route('invoice-drafts.show', trans('app.back'), $draft->draftKey)
    ]) !!}
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.detail') }}</h3></div>
            @php
                $project = App\Entities\Projects\Project::findOrFail($draft->projectId);
            @endphp
            <table class="table">
                <tbody>
                    <tr><td>{{ trans('invoice.project') }}</td><td>{{ $project->name }}</td></tr>
                    <tr><td>{{ trans('customer.customer') }}</td><td>{{ $project->customer->name }}</td></tr>
                    <tr><td>{{ trans('invoice.date') }}</td><td>{{ $draft->date }}</td></tr>
                    <tr><td>{{ trans('invoice.due_date') }}</td><td>{{ $draft->dueDate }}</td></tr>
                    <tr>
                        <td>{{ trans('invoice.total') }}</td>
                        <th class="text-right lead">{{ format_money($draft->getTotal()) }}</th>
                    </tr>
                    <tr><td>{{ trans('invoice.notes') }}</td><td>{{ $draft->notes }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                {{ Form::open(['route' => ['invoice-drafts.store', $draft->draftKey]]) }}
                {{ Form::submit(trans('invoice.save'), ['id' => 'save-invoice-draft', 'class' => 'btn btn-success']) }}
                {{ link_to_route('invoice-drafts.show', trans('app.back'), $draft->draftKey, ['class' => 'btn btn-default']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('invoice.items') }}</h3></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('app.table_no') }}</th>
                            <th>{{ trans('invoice.item_description') }}</th>
                            <th class="text-right">{{ trans('invoice.item_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($draft->items() as $key => $item)
                        <tr>
                            <td width="5%">{{ $key + 1 }}</td>
                            <td width="70%">{!! nl2br($item->description) !!}</td>
                            <td width="25%" class="text-right">{{ format_money($item->amount) }}</td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right">{{ trans('invoice.total') }} :</th>
                            <th class="text-right">{{ format_money($draft->getTotal()) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
