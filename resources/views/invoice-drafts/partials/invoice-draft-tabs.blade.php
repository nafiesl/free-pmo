<?php use Facades\App\Services\InvoiceDrafts\InvoiceDraftCollection;?>
<ul class="nav nav-tabs transaction-draft-tabs" style="margin-bottom: 15px">
    @foreach(InvoiceDraftCollection::content() as $key => $content)
        <?php $active = ($draft->draftKey == $key) ? 'class=active' : ''?>
        <li {{ $active }} role="presentation">
            <a href="{{ route('invoice-drafts.show', $key) }}">
                {{ trans('invoice.invoice') }} - {{ $key }}
                <form action="{{ route('invoice-drafts.remove', $key) }}" method="post" style="display:inline" onsubmit="return confirm('{{ __('invoice.draft_del_confirm') }}')">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <input type="hidden" name="draft_key" value="{{ $key }}">
                    <input type="submit" id="remove_draft_{{ $key }}" value="x" style="margin: -2px -7px 0px 0px" class="btn-link btn-xs pull-right">
                </form>
            </a>
        </li>
    @endforeach
</ul><!-- Tab panes -->