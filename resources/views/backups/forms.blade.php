@if (request('action') == 'delete' && Request::has('file_name'))
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">{{ __('backup.delete') }}</h3>
        </div>
        <div class="panel-body">
            <p>{!! __('backup.sure_to_delete_file', ['filename' => request('file_name')]) !!}</p>
        </div>
        <div class="panel-footer">
            <a href="{{ route('backups.index') }}" class="btn btn-default">{{ __('backup.cancel_delete') }}</a>
            <form action="{{ route('backups.destroy', request('file_name')) }}"
                method="post"
                class="pull-right"
                onsubmit="return confirm('{{ __('app.delete_confirm') }}')">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <input type="hidden" name="file_name" value="{{ request('file_name') }}">
                <input type="submit" class="btn btn-danger" value="{{ __('backup.confirm_delete') }}">
            </form>
        </div>
    </div>
@endif
@if (request('action') == 'restore' && Request::has('file_name'))
    <div class="panel panel-warning">
        <div class="panel-heading"><h3 class="panel-title">{{ __('backup.restore') }}</h3></div>
        <div class="panel-body">
            <p>{!! __('backup.sure_to_restore', ['filename' => request('file_name')]) !!}</p>
        </div>
        <div class="panel-footer">
            <a href="{{ route('backups.index') }}" class="btn btn-default">{{ __('backup.cancel_restore') }}</a>
            <form action="{{ route('backups.restore', request('file_name')) }}"
                method="post"
                class="pull-right"
                onsubmit="return confirm('Click OK to Restore.')">
                {{ csrf_field() }}
                <input type="hidden" name="file_name" value="{{ request('file_name') }}">
                <input type="submit" class="btn btn-warning" value="{{ __('backup.confirm_restore') }}">
            </form>
        </div>
    </div>
@endif
@if (request('action') == null)
<div class="panel panel-default">
    <div class="panel-body">
        <form action="{{ route('backups.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="file_name" class="control-label">{{ __('backup.create') }}</label>
                <input type="text" name="file_name" class="form-control" placeholder="{{ date('Y-m-d_Hi') }}">
                {!! $errors->first('file_name', '<div class="text-danger text-right">:message</div>') !!}
            </div>
            <div class="form-group">
                <input type="submit" value="{{ __('backup.create') }}" class="btn btn-success">
            </div>
        </form>
        <hr>
        <form action="{{ route('backups.upload') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="backup_file" class="control-label">{{ __('backup.upload') }}</label>
                <input type="file" name="backup_file" class="form-control">
                {!! $errors->first('backup_file', '<div class="text-danger text-right">:message</div>') !!}
            </div>
            <div class="form-group">
                <input type="submit" value="{{ __('backup.upload') }}" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>
@endif
