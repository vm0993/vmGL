<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles
        
    </head>
    <body class="main">
        <div class="mobile-menu mobile-menu--dashboard md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="vimaGL" class="w-6" src="{{ asset('images/logovm.png') }}">
                </a>
                <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-gray-600 dark:text-white transform -rotate-90"></i> </a>
            </div>
            <ul class="mobile-menu-box py-5 hidden">
                
            </ul>
        </div>
        <div class="flex overflow-hidden">
            @livewire('navigation-menu')
            <div class="content  content--dashboard">
                @include('top-bar')
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
        @include('switcher')
        
        @stack('modals')

        @livewireScripts
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBG7gNHAhDzgYmq4-EHvM4bqW1DNj2UCuk&libraries=places"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
    </body>
</html>
