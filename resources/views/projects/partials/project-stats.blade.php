<div class="row">
    <div class="col-lg-6 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" title="Progress Berdasarkan Index Bobot Biaya Fitur">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-tasks fa-4x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" style="font-size: 38px;">{{ format_decimal($project->getJobOveralProgress()) }} %</div>
                        <div class="lead">{{ __('project.overall_progress') }}</div>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-6 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" title="Total Job dan Task">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-paperclip fa-4x"></i></div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $project->jobs->count() }} Job</div>
                        <div class="lead">{{ $project->tasks->count() }} Task</div>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    @can('see-pricings', $project)
    <div class="col-lg-6 col-md-12">
        <a href="{{ route('projects.jobs.index',[$project->id]) }}" title="Collectible Earnings">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <i class="fa fa-money fa-2x pull-left"></i>
                        <div class="lead">Collectibe Earnings</div>
                        <div class="lead" style="font-size: 30px;">{{ format_money($project->getCollectibeEarnings()) }}</div>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    @endcan
    <div class="clearfix"></div>
</div>
