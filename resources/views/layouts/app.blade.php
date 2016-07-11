<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="x-csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', Option::get('app_name', 'Aplikasi Laravel'))</title>

    {!! Html::style('assets/css/plugins/metisMenu/metisMenu.min.css') !!}
    @yield('ext_css')
    {!! Html::style('assets/css/app.css') !!}
</head>
<body>
    <div id="wrapper">

        @include('layouts.partials.sidebar')

        <div id="page-wrapper">
            {{-- @include('layouts.partials.top-nav') --}}
            @include('flash::message')
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        @include('layouts.partials.footer')
    </div>
    <!-- /#wrapper -->

    {!! Html::script(url('assets/js/jquery.js')) !!}
    {!! Html::script(url('assets/js/bootstrap.min.js')) !!}
    {!! Html::script(url('assets/js/plugins/metisMenu/metisMenu.min.js')) !!}
    @yield('ext_js')
    {!! Html::script(url('assets/js/sb-admin-2.js')) !!}

    <script type="text/javascript">
    (function() {
        $("div.alert.notifier, div.alert.add-cart-notifier").delay(5000).slideUp('slow');
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content')
            }
        });
    })();
    </script>

    @yield('script')

</body>
</html>