<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('customers.show', trans('customer.show'), [$customer]) !!}
    </li>
</ul>
<br>
