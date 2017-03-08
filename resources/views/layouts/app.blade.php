<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/blue-dark.css') }}">
</head>
<body>
        @yield('content')

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        {{--<script src="{{ asset('js/jasny-bootstrap.js') }}"></script>--}}
        <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
        {{--<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>--}}
        {{--@yield('scripts')--}}
        <script src="{{ asset('js/custom.min.js') }}"></script>
        {{--<script src="{{ asset('js/wp-sidebar.js') }}"></script>--}}
</body>
</html>
