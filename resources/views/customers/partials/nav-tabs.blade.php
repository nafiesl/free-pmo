<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('customers.show', trans('customer.detail'), [$customer]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'projects' ? 'active' : '' }}">
        {!! link_to_route('customers.projects', trans('customer.projects').' ('.$customer->projects->count().')', [$customer]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'payments' ? 'active' : '' }}">
        {!! link_to_route('customers.payments', trans('customer.payments').' ('.$customer->payments->count().')', [$customer]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'subscriptions' ? 'active' : '' }}">
        {!! link_to_route('customers.subscriptions', trans('customer.subscriptions').' ('.$customer->subscriptions->count().')', [$customer]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'invoices' ? 'active' : '' }}">
        {!! link_to_route('customers.invoices', trans('customer.invoices').' ('.$customer->invoices->count().')', [$customer]) !!}
    </li>
</ul>
<br>
