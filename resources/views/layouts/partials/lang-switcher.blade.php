<div class="text-center" style="border-bottom: 1px solid #e7e7e7; padding-bottom: 10px">
    {{ trans('lang.lang') }} :
    {!! FormField::formButton(
        [
            'route'  => 'users.profile.switch-lang',
            'method' => 'patch',
            'title'  => auth()->user()->lang != 'en' ? trans('lang.switch_tooltip', ['lang' => trans('lang.en')]) : ''
        ],
        'EN',
        ['class' => 'btn btn-default btn-xs', 'id' => 'switch_lang_en']
        + (auth()->user()->lang == 'en' ? ['disabled' => 'disabled'] : []),
        ['lang' => 'en']
    ) !!}
    {!! FormField::formButton(
        [
            'route'  => 'users.profile.switch-lang',
            'method' => 'patch',
            'title'  => auth()->user()->lang != 'id' ? trans('lang.switch_tooltip', ['lang' => trans('lang.id')]) : ''
        ],
        'ID',
        ['class' => 'btn btn-default btn-xs', 'id' => 'switch_lang_id']
        + (auth()->user()->lang == 'id' ? ['disabled' => 'disabled'] : []),
        ['lang' => 'id']
    ) !!}
    {!! FormField::formButton(
        [
            'route'  => 'users.profile.switch-lang',
            'method' => 'patch',
            'title'  => auth()->user()->lang != 'de' ? trans('lang.switch_tooltip', ['lang' => trans('lang.de')]) : ''
        ],
        'DE',
        ['class' => 'btn btn-default btn-xs', 'de' => 'switch_lang_de']
        + (auth()->user()->lang == 'de' ? ['disabled' => 'disabled'] : []),
        ['lang' => 'de']
    ) !!}
</div>
