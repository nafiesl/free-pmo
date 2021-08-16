@extends('layouts.app')

@section('title', __('report.yearly', ['year' => $year]))

@section('content')
<ul class="breadcrumb hidden-print">
    <li>{{ __('report.yearly', ['year' => $year]) }}</li>
</ul>

{{ Form::open(['method' => 'get', 'class' => 'form-inline well well-sm']) }}
{{ Form::label('year', __('report.view_yearly_label'), ['class' => 'control-label']) }}
{{ Form::select('year', $years, $year, ['class' => 'form-control']) }}
{{ Form::submit(__('report.view_report'), ['class' => 'btn btn-info btn-sm']) }}
{{ link_to_route('reports.payments.yearly', __('report.this_year'), [], ['class' => 'btn btn-default btn-sm']) }}
{{ link_to_route('reports.payments.year_to_year', __('report.view_year_to_year'), [], ['class' => 'btn btn-success btn-sm']) }}
<div class="btn-group pull-right" role="group">
    {{ link_to_route('reports.payments.yearly', 'In Months', array_merge(request()->all(), ['format' => 'in_months']), ['class' => 'btn btn-sm '.(in_array(request('format'), ['in_months', null]) ? 'btn-info' : 'btn-default')]) }}
    {{ link_to_route('reports.payments.yearly', 'In Weeks', array_merge(request()->all(), ['format' => 'in_weeks']), ['class' => 'btn btn-sm '.(in_array(request('format'), ['in_weeks']) ? 'btn-info' : 'btn-default')]) }}
</div>
{{ Form::close() }}

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">{{ __('report.sales_graph') }} {{ $year }}</h3></div>
    <div class="panel-body">
        <strong>{{ Option::get('money_sign', 'Rp') }}</strong>
        <div id="yearly-chart" style="height: 250px;"></div>
        <div class="text-center"><strong>{{ __('time.month') }}</strong></div>
    </div>
</div>

<div class="panel panel-success table-responsive">
    <div class="panel-heading"><h3 class="panel-title">{{ __('report.detail') }}</h3></div>
    <div class="panel-body table-responsive">
        @includeWhen($reportFormat == 'in_months', 'reports.payments.partials.yearly_in_months', compact('reports'))
        @includeWhen($reportFormat == 'in_weeks', 'reports.payments.partials.yearly_in_weeks', compact('reports'))
    </div>
</div>
@endsection

@section('ext_css')
    {{ Html::style(url('assets/css/plugins/morris.css')) }}
@endsection

@section('ext_js')
    {{ Html::script(url('assets/js/plugins/morris/raphael.min.js')) }}
    {{ Html::script(url('assets/js/plugins/morris/morris.min.js')) }}
@endsection

@section('script')
<script>
(function() {
    new Morris.Line({
        element: 'yearly-chart',
        data: {!! $chartData->toJson() !!},
        xkey: "{{ in_array(request('format'), ['in_weeks']) ? 'week' : 'month' }}",
        ykeys: ['value'],
        labels: ["{{ __('report.profit') }} {{ Option::get('money_sign', 'Rp') }}"],
        parseTime:false,
        goals: [0],
        goalLineColors : ['red'],
        smooth: true,
        lineWidth: 2,
    });
})();
</script>
@endsection
