$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
                //ajaxLoad(data.redirect_url);
                table.draw();
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

function showDeleteData(id){
    $('#del-titleHeader').text('Hapus Data');
    $('#id_delHeader').val(id);
    //console.log(id);
    $('#info_deleteData').text('Yakin ingin menghapus data ini?');
    $('#delHeader').modal('show');
}

$(document).on("click",'#delHeaderConfirm',(function(){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var id_data = $('#id_delHeader').val();
    //console.log(id_data);
    $.ajax({
        url :  uri + '/' + id_data ,
        type : "POST",
        data : {'_method' : 'DELETE', '_token' : csrf_token},
        success : function(data) {
            $('#delHeader').modal('hide');
            table.draw();
        }
    });
}));

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function changeNumber(num){
    return num.toString().replace(',', '')
}