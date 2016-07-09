@extends('layouts.app')

@section('title', trans('feature.delete'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {!! FormField::delete([
            'route'=>['features.destroy',$feature->id]],
            trans('app.delete_confirm_button'),
            ['class'=>'btn btn-danger'],
            [
                'feature_id'=>$feature->id,
                'project_id'=>$feature->project_id,
            ]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('features.show', trans('app.cancel'), [$feature->id], ['class' => 'btn btn-default']) !!}
</h1>
<div class="row">
    <div class="col-md-4">
        @include('features.partials.feature-show')
    </div>
</div>
@endsection