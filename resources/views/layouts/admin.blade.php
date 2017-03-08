<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>NFBox Admin</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/sidebar-nav.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/blue-dark.css') }}">

    @yield('styles')
</head>
<body>
    <div id="wrapper">

        @include('partials._navbar')


        @include('partials._sidebar')

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    @yield('page-title')
                </div>
                @yield('content')
            </div>
        </div>

    </div>

    @include('partials._model')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/wp-sidebar.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>