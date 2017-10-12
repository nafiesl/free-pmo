@extends('layouts.app')

@section('content')
<ul class="breadcrumb hidden-print">
    <li class="active">Dashboard</li>
</ul>

<div class="well well-sm">
    {!! Form::open(['route' => 'projects.index','method'=>'get','class'=>'form-inline']) !!}
    {!! Form::text('q', Request::get('q'), [
        'class' => 'form-control index-search-field',
        'placeholder' => trans('project.search'),
        'style' => 'width:100%;max-width:350px'
    ]) !!}
    {!! Form::submit(trans('project.search'), ['class' => 'btn btn-info btn-sm']) !!}
    {!! Form::close() !!}
</div>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('projects.index',['status' => 1]) }}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-paperclip fa-5x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ array_key_exists(1, $projectsCount) ? $projectsCount[1] : 0 }}</div>
                        <div class="lead">{{ getProjectStatusesList(1) }}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                View Details <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('projects.index',['status' => 2]) }}">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-tasks fa-5x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ array_key_exists(2, $projectsCount) ? $projectsCount[2] : 0 }}</div>
                        <div class="lead">{{ getProjectStatusesList(2) }}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                View Details <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('projects.index',['status' => 3]) }}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-thumbs-o-up fa-5x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ array_key_exists(3, $projectsCount) ? $projectsCount[3] : 0 }}</div>
                        <div class="lead">{{ getProjectStatusesList(3) }}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                View Details <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('projects.index',['status' => 4]) }}">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-money fa-5x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ array_key_exists(4, $projectsCount) ? $projectsCount[4] : 0 }}</div>
                        <div class="lead">{{ getProjectStatusesList(4) }}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                View Details <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-lg-offset-3">
        <a href="{{ route('projects.index',['status' => 5]) }}">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-smile-o fa-5x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ array_key_exists(5, $projectsCount) ? $projectsCount[5] : 0 }}</div>
                        <div class="lead">{{ getProjectStatusesList(5) }}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                View Details <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('projects.index',['status' => 6]) }}">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-hand-paper-o fa-5x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ array_key_exists(6, $projectsCount) ? $projectsCount[6] : 0 }}</div>
                        <div class="lead">{{ getProjectStatusesList(6) }}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                View Details <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            </div>
        </div>
        </a>
    </div>
</div>
@endsection