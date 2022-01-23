<html lang="en" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="vmGL, Simplify Bookeeping,">
        <meta name="keywords" content="Open Source Accounting App, Free Accounting & Mobile App">
        <meta name="author" content="Visca">
        <title>{{ config('app.name', 'vmGL') }}</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body class="{{ \Route::current()->getName()=='dashboard' ? 'main' : 'py-5' }}">
        @include('template.mobile')
        <div class="flex">
            @include('template.sidebar')
            <div class="content">
                @include('template.topbar')

                {{-- <div class="grid grid-cols-12 gap-6"> --}}
                    @yield('content')
                {{-- </div> --}}
            </div>
            @include('template.modals.modal')
        </div>
        <script src="{{ mix('dist/js/app.js') }}"></script>
        @stack('scripts')
        <script type="text/javascript">
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

            @if(\Route::current()->getName()!='dashboard')
                $('#modalForm').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    ajaxLoad(button.data('href'), 'modal_content');
                });
                
                $('#modalDelete').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    $('#delete_id').val(button.data('id'));
                    $('#delete_token').val(button.data('token'));
                });
                
                $('#modalForm').on('shown.bs.modal', function () {
                    $('#focus').trigger('focus')
                });
                
                $(document).on('submit', 'form#frm', function (event) {
                    event.preventDefault();
                    var form = $(this);
                    var data = new FormData($(this)[0]);
                    var url = form.attr("action");
                    $.ajax({
                        type: form.attr('method'),
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('#modalForm form')[0].reset();
                            $('.is-invalid').removeClass('is-invalid');
                            if (data.fail) {
                                for (control in data.errors) {
                                    $('input[name=' + control + ']').addClass('is-invalid');
                                    $('#error-' + control).html(data.errors[control]);
                                }
                            } else {
                                $('#modalForm').modal('hide');
                                ajaxLoad(data.redirect_url);
                                //table.draw();
                            }
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            alert("Error: " + errorThrown);
                            associate_errors
                        }
                    });
                    return false;
                });
                
                function associate_errors(errors, $form) {
                    //remove existing error classes and error messages from form groups
                    $form.find('.form-group').removeClass('has-errors').find('.help-text').text('');
                    errors.foreach(function (value, index) {
                        //find each form group, which is given a unique id based on the form field's name
                        var $group = $form.find('#' + index + '-group');
                        //add the error class and set the error text
                        $group.addClass('has-errors').find('.help-text').text(value);
                    });
                }
                
                function ajaxLoad(filename, content) {
                    content = typeof content !== 'undefined' ? content : 'content';
                    $('.loading').show();
                    $.ajax({
                        type: "GET",
                        url: filename,
                        contentType: false,
                        success: function (data) {
                            console.log(data);
                            $("#" + content).html(data);
                            $('.loading').hide();
                        },
                        error: function (xhr, status, error) {
                            alert(xhr.responseText);
                        }
                    });
                }
                
                $('#modalDelete').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    $('#delete_id').val(button.data('id'));
                    $('#delete_token').val(button.data('token'));
                });
            @endif

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </body>
</html>