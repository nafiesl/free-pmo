<?php
$class     = isset($class) ? $class : 'default';
$icon      = isset($icon) ? $icon : 'tasks';
$number    = isset($number) ? $number : 0;
$text      = isset($text) ? $text : 'Info Text';
$linkText  = isset($linkText) ? $linkText : trans('app.show');
$linkRoute = isset($linkRoute) ? $linkRoute : '#';
?>

<a href="{{ $linkRoute }}">
    <div class="panel panel-{{ $class }}">
        <div class="panel-heading" style="padding:6px 10px">
            <div class="row">
                <div class="col-xs-3"><i class="fa fa-{{ $icon }} fa-3x"></i></div>
                <div class="col-xs-9 text-center">
                    <div style="font-size: 35px; line-height: 40px;">{{ $number }}</div>
                    <div class="lead">{{ $text }}</div>
                </div>
            </div>
        </div>
        <div class="panel-footer" style="padding:6px 10px">
            {{ $linkText }} <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
        </div>
    </div>
</a>
