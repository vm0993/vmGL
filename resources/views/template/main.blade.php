<html lang="{{ str_replace('_', '-', Session()->get('applocale')) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="vmGL, Simplify Bookeeping,">
        <meta name="keywords" content="Open Source Accounting App, Free Accounting & Mobile App">
        <meta name="author" content="Visca">
        <title>{{ config('app.name', 'vmGL') }}</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body class="{{ \Route::current()->getName()=='dashboard' ? 'main' : 'py-5' }}">
        @include('template.mobile')
        <div class="flex overflow-hidden">
            @include('template.sidebar')
            <div class="content {{ \Route::current()->getName()=='dashboard' ? 'content--dashboard' : '' }}">
                @include('template.topbar')

                {{-- <div class="grid grid-cols-12 gap-6"> --}}
                    @yield('content')
                {{-- </div> --}}
            </div>
            @include('template.modals.modal')
        </div>
        <script src="{{ mix('dist/js/app.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
        @stack('scripts')
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                switch(type){
                    case 'info':
                        toastr.info("{{ Session::get('message') }}");
                        break;

                    case 'warning':
                        toastr.warning("{{ Session::get('message') }}");
                        break;

                    case 'success':
                        toastr.success("{{ Session::get('message') }}");
                        break;

                    case 'error':
                        toastr.error("{{ Session::get('message') }}");
                        break;
                }
            @endif
        </script>
    </body>
</html>