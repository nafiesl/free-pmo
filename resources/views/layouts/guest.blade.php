<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="x-csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', config('app.name'))</title>

    {!! Html::style('assets/css/app.css') !!}
    @yield('ext_css')
</head>
<body>
    <div class="container">
        <div class="row">
            @yield('content')
        </div>
        @include('layouts.partials.footer')
    </div>

    {!! Html::script(url('assets/js/jquery.js')) !!}
    {!! Html::script(url('assets/js/bootstrap.min.js')) !!}
    @include('layouts.partials.noty')
    @yield('ext_js')

    <script type="text/javascript">
    (function() {
        $("div.alert.notifier").delay(10000).fadeOut();
    })();
    </script>

    @yield('script')
</body>
</html>
