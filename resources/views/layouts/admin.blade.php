<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NFBox Admin</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <link rel="stylesheet" href="/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" href="/css/sidebar-nav.min.css">

    <link rel="stylesheet" href="/css/style.css">

    <link rel="stylesheet" href="/css/blue-dark.css">

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

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jasny-bootstrap.js"></script>
    <script src="/js/jquery.slimscroll.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    @yield('scripts')
    <script src="/js/custom.min.js"></script>
    <script src="/js/wp-sidebar.js"></script>
</body>
</html>