<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    @yield('meta')

    <title>@yield('title')</title>

    @section('css')
        <link rel="stylesheet" href="/components/bootstrap/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/components/datetimepicker/jquery.datetimepicker.css"/>
        <link rel="stylesheet" href="/components/select2/dist/css/select2.css"/>
        <link rel="stylesheet" href="/components/dropzone/dist/min/dropzone.min.css" />
        <link rel="stylesheet" href="/css/main.css"/>
    @show

    @section('script')
        <script src="/components/jquery/dist/jquery.min.js"></script>
        <script src="/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/js/main.js"></script>
        <script src="/components/datetimepicker/jquery.datetimepicker.js"></script>
        <script src="/components/select2/dist/js/select2.js"></script>
        <script src="/components/tinymce/tinymce.min.js"></script>
        <script src="/components/dropzone/dist/min/dropzone.min.js"></script>
    @show
</head>

<body id="@yield('bodyId')">
@include('admin.shared._navbar')

@yield('top')

<div class="wrapper">
    <div class="container">
        @include('flash::message')

        @section('grid')
            <div class="row">
                <div class="col-sm-3">
                    @section('sidebar')
                        @include('admin.shared._menu')
                    @show
                </div>

                <div class="col-sm-9">
                    @section('content')
                        Display content here.
                    @show
                </div>
            </div>
        @show
    </div>
</div>

@yield('bottom')

@include('shared._footer')
</body>
</html>
