<html lang="{{ str_replace('_', '-', Session()->get('applocale')) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="vmGL, Simplify Bookeeping,">
        <meta name="keywords" content="Open Source Accounting App, Free Accounting & Mobile App">
        <title>{{ config('app.name', 'vmGL Login') }}</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
    </head>
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                @yield('content')
            </div>
        </div>
        <script src="{{ mix('dist/js/app.js') }}" defer></script>
    </body>
</html>