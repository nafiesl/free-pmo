<div class="text-center" style="border-bottom: 1px solid #e7e7e7; padding-bottom: 10px">
    {{ trans('lang.lang') }} :

    @foreach (['en', 'id', 'de'] as $langKey)
        {!! FormField::formButton(
            [
                'route'  => 'users.profile.switch-lang',
                'method' => 'patch',
                'title'  => auth()->user()->lang != $langKey ? trans('lang.switch_tooltip', ['lang' => trans('lang.'.$langKey)]) : ''
            ],
            strtoupper($langKey),
            ['class' => 'btn btn-default btn-xs', 'id' => 'switch_lang_'.$langKey]
            + (auth()->user()->lang == $langKey ? ['disabled' => 'disabled'] : []),
            ['lang' => $langKey]
        ) !!}
    @endforeach
</div>
