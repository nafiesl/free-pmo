<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', Option::get('app_name', 'Aplikasi Laravel'))</title>

    {!! Html::style('assets/css/print.css') !!}
    @yield('style')
</head>
<body>
    @yield('content')
    {!! Html::script(url('assets/js/jquery.js')) !!}
</body>
</html>
