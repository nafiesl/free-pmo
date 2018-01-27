<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('customers.show', trans('customer.show'), [$customer]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'projects' ? 'active' : '' }}">
        {!! link_to_route('customers.projects', trans('customer.projects').' ('.$customer->projects->count().')', [$customer]) !!}
    </li>
</ul>
<br>
