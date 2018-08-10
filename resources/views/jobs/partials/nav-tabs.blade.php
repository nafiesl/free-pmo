<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('jobs.show', __('job.detail'), $job) !!}
    </li>
    @can('view-comments', $job)
    <li class="{{ Request::segment(3) == 'comments' ? 'active' : '' }}">
        {!! link_to_route('jobs.comments.index', __('comment.list').' ('.$job->comments->count().')', $job) !!}
    </li>
    @endcan
</ul>
<br>
