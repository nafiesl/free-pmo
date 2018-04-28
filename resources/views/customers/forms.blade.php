@if (Request::get('action') == 'delete' && $customer)
@php
    $dependentRecordsCount = 0;
@endphp
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('customer.delete') }}</h3></div>
            <div class="panel-body">
                <label class="control-label">{{ trans('customer.name') }}</label>
                <p>{{ $customer->name }}</p>
                <label class="control-label">{{ trans('contact.email') }}</label>
                <p>{{ $customer->email }}</p>
                <label class="control-label">{{ trans('app.status') }}</label>
                <p>{{ $customer->is_active }}</p>
                <label class="control-label">{{ trans('customer.projects_count') }}</label>
                <p>{{ $projectsCount = $customer->projects()->count() }}</p>
                @php $dependentRecordsCount += $projectsCount; @endphp
                <label class="control-label">{{ trans('customer.subscriptions_count') }}</label>
                <p>{{ $subscriptionsCount = $customer->subscriptions()->count() }}</p>
                @php $dependentRecordsCount += $subscriptionsCount; @endphp
                <label class="control-label">{{ trans('app.notes') }}</label>
                <p>{{ $customer->notes }}</p>
                {!! $errors->first('customer_id', '<span class="form-error small">:message</span>') !!}
            </div>
            <hr style="margin:0">
            @if ($dependentRecordsCount)
                <div class="panel-body">{{ trans('customer.undeleteable') }}</div>
            @else
                <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
            @endif
            <div class="panel-footer">
                @can('delete', [$customer, $dependentRecordsCount])
                    {!! FormField::delete(
                        ['route'=>['customers.destroy',$customer->id]],
                        trans('app.delete_confirm_button'),
                        ['class'=>'btn btn-danger'],
                        [
                            'customer_id' => $customer->id,
                            'page' => request('page'),
                            'q' => request('q'),
                        ]
                    ) !!}
                @endcan
                {{ link_to_route('customers.edit', trans('app.cancel'), [$customer->id], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
</div>
@endif
