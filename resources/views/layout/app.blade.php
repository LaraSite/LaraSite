<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    @yield('meta')

    <title>@yield('title')</title>

    @section('css')
        <link rel="stylesheet" href="/components/bootstrap/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/css/main.css"/>
    @show
</head>

<body id="@yield('bodyId')">
@include('shared._navbar')

@yield('top')

<div class="wrapper">
    <div class="container">
        @include('flash::message')

        @section('grid')
            @section('content')
                Display contents here.
            @show
        @show
    </div>
</div>

@yield('bottom')

@include('shared._footer')

@section('script')
    <script src="/components/jquery/dist/jquery.min.js"></script>
    <script src="/components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/js/main.js"></script>
@show
</body>
</html>
