<html lang="{{ str_replace('_', '-', Session()->get('applocale')) }}" class="">
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
        @yield('css')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body class="py-5">
        @include('template.mobile')
        <div class="flex">
            @include('template.sidebar')
            <div class="content {{ \Route::current()->getName()=='dashboard' ? 'content--dashboard' : '' }}">
                @include('template.topbar')

                {{-- <div class="grid grid-cols-12 gap-6"> --}}
                    @yield('content')
                {{-- </div> --}}
            </div>
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

            window.addEventListener('DOMContentLoaded',()=>{
                document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
                    element.addEventListener('keyup', function(e) {
                        let cursorPostion = this.selectionStart;
                        let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                        let originalLenght = this.value.length;
                        if (isNaN(value)) {
                            this.value = "";
                        } else {    
                            this.value = value.toLocaleString('id-ID', {
                                currency: 'IDR',
                                style: 'currency',
                                minimumFractionDigits: 0
                            });
                            cursorPostion = this.value.length - originalLenght + cursorPostion;
                            this.setSelectionRange(cursorPostion, cursorPostion);
                        }
                    });
                });
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
        <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
        <script>

            var firebaseConfig = {
                apiKey: "AIzaSyBwQQ0xDNCCJY2j8JkfdUNjKbjt035yHao",
                authDomain: "vimaapp-32500.firebaseapp.com",
                projectId: "vimaapp-32500",
                storageBucket: "vimaapp-32500.appspot.com",
                messagingSenderId: "693288984780",
                appId: "1:693288984780:web:1e8e73f0bbfcf282aca269",
                measurementId: "G-5LV9FWRJH9"
            };
            
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();
            console.log(messaging);
        
            function initFirebaseMessagingRegistration() {
                    messaging
                    .requestPermission()
                    .then(function () {
                        return messaging.getToken()
                    })
                    .then(function(token) {
                        console.log(token);
        
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
        
                        $.ajax({
                            url: '{{ route("store-token") }}',
                            type: 'PATCH',
                            data: {
                                token: token
                            },
                            dataType: 'JSON',
                            success: function (response) {
                                alert('Token saved successfully.');
                            },
                            error: function (err) {
                                console.log('User Chat Token Error'+ err);
                            },
                        });
        
                    }).catch(function (err) {
                        console.log('User Chat Token Error'+ err);
                    });
            }  
            
            messaging.onMessage(function(payload) {
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });
        
        </script>
    </body>
</html>