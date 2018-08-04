@extends('layouts.project')

@section('subtitle', __('comment.list'))

@section('content-project')
<div class="row">
    <div class="col-md-8 col-md-offset-1">
        {{ $comments->links() }}
        @include('projects.partials.comment-section')
        {{ $comments->links() }}
    </div>
</div>

@endsection
