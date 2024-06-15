$(document).ready(function() {
    $('#cp-form').submit(function(e) {
        e.preventDefault();
        cpSubmit(this);
    });
    
    $('.form-reset').on('click', function() {
        formReset();
    });
});

function cpSubmit(form) {
    $.ajax({
        type: 'post',
        url: baseUrl + 'update-password/post',
        data: new FormData(form),
        beforeSend: function() {
            $('#cp-form-submit-result').remove();
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
            $('.btn').attr('disabled', true);
            $('.form-reset').after(' <img src="' + basicLoader + '" id="cp-form-loader" />');
            $('.form-control').removeClass('is-invalid');
            $('.error-message').html('');
        },
        complete: function() {},
        success: function(data) {
            console.log(data);
            var obj = $.parseJSON(data);
            $('html, body').animate({scrollTop : 0}, 100);
            if (obj.code == 200) {
                var msg = 'Kata Sandi Anda berhasil diubah.';
                var res = pageAlert('cp-form-submit-result', msg, 'success', true, 'check');
                $('#cp-form').before(res);
                $('.form-control').val('');
                formReset();
            } else {
                for (var key in obj.errors) {
                    if (obj.errors.hasOwnProperty(key)) {
                        $('#error-' + key).html(obj.errors[key]);
                        if (obj.errors[key] !== '') {
                            $('#' + key).addClass('is-invalid');
                        } else {
                            if (!$('#' + key).is(':disabled')) {
                                $('#' + key).addClass('is-valid');
                            }
                        }
                    }
                }
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    
    formAfterProcess();
}

function formReset() {
    enableAllFields();
    removeValidInvalidClass();
    $('html, body').animate({scrollTop : 0}, 100);
}

function enableAllFields() {
    $('.form-control').attr('disabled', false);
}

function removeValidInvalidClass() {
    $('.form-control').removeClass('is-valid');
    $('.form-control').removeClass('is-invalid');
    $('.error-message').html('');
}

function formAfterProcess() {
    enableAllFields();
    $('#cp-form .btn').attr('disabled', false);
    $('#cp-form-loader').remove();
}